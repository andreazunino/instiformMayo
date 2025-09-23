<?php

class Inscripcion
{
    private $pdo;
    private $tablaCalificacionesDisponible = null;

    public function __construct($conexion)
    {
        $this->pdo = $conexion;
    }

    // Inscribir a un estudiante en un curso
    public function inscribir($dniEstudiante, $idCurso)
    {
        $stmt = $this->pdo->prepare("INSERT INTO inscripcion (dni_estudiante, id_curso) VALUES (?, ?)");
        return $stmt->execute([$dniEstudiante, $idCurso]);
    }

    // Ver en qué cursos está inscrito un estudiante
    public function obtenerCursosPorDNI($dniEstudiante)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.nombre
            FROM curso c
            INNER JOIN inscripcion i ON c.id = i.id_curso
            WHERE i.dni_estudiante = ?
        ");
        $stmt->execute([$dniEstudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Cursos disponibles para un estudiante (que no esté inscrito y con cupo)
    public function cursosDisponiblesParaEstudiante($dniEstudiante)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.id, c.nombre, c.cupo
            FROM curso c
            WHERE c.cupo > 0
              AND c.id NOT IN (
                SELECT id_curso FROM inscripcion WHERE dni_estudiante = ?
              )
        ");
        $stmt->execute([$dniEstudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Anular inscripción de un estudiante a un curso
    public function anular($dniEstudiante, $idCurso)
    {
        $stmt = $this->pdo->prepare("DELETE FROM inscripcion WHERE dni_estudiante = ? AND id_curso = ?");
        return $stmt->execute([$dniEstudiante, $idCurso]);
    }

    // Listar todas las inscripciones (para el administrador)
    public function listarInscripciones()
    {
        $stmt = $this->pdo->query("
            SELECT i.id, i.dni_estudiante as dni, e.nombre, e.apellido, c.nombre as curso
            FROM inscripcion i
            INNER JOIN estudiante e ON i.dni_estudiante = e.dni
            INNER JOIN curso c ON i.id_curso = c.id
            ORDER BY e.apellido, e.nombre
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener las notas del boletín de un estudiante (todas las cargas registradas)
    public function obtenerNotasPorDNI($dniEstudiante)
    {
        if ($this->tieneTablaCalificaciones()) {
            $stmt = $this->pdo->prepare("
                SELECT
                    c.nombre AS materia,
                    i.calificacion AS ultima_calificacion,
                    i.fecha_calificacion,
                    COALESCE(
                        json_agg(
                            json_build_object(
                                'valor', ic.calificacion,
                                'fecha', ic.fecha_registro
                            ) ORDER BY ic.fecha_registro
                        ) FILTER (WHERE ic.id IS NOT NULL),
                        '[]'
                    ) AS historial
                FROM inscripcion i
                INNER JOIN curso c ON i.id_curso = c.id
                LEFT JOIN inscripcion_calificaciones ic ON ic.inscripcion_id = i.id
                WHERE i.dni_estudiante = ?
                  AND (i.calificacion IS NOT NULL OR ic.id IS NOT NULL)
                GROUP BY c.nombre, i.calificacion, i.fecha_calificacion, i.id
                ORDER BY c.nombre
            ");
            $stmt->execute([$dniEstudiante]);
            $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return array_map(function (array $registro) {
                $historial = json_decode($registro['historial'], true);
                if (!is_array($historial)) {
                    $historial = [];
                }

                $calificaciones = [];
                foreach ($historial as $entrada) {
                    if (!isset($entrada['valor'])) {
                        continue;
                    }
                    $calificaciones[] = $this->formatearEntradaCalificacion($entrada['valor'], $entrada['fecha'] ?? null);
                }

                if (empty($calificaciones) && $registro['ultima_calificacion'] !== null) {
                    $calificaciones[] = $this->formatearEntradaCalificacion($registro['ultima_calificacion'], $registro['fecha_calificacion'] ?? null);
                }

                $registro['calificaciones'] = $calificaciones;
                $registro['calificacion'] = $this->unirValoresCalificaciones($calificaciones);
                unset($registro['historial'], $registro['ultima_calificacion'], $registro['fecha_calificacion']);

                return $registro;
            }, $registros);
        }

        $stmt = $this->pdo->prepare("
            SELECT c.nombre AS materia, i.calificacion, i.fecha_calificacion
            FROM inscripcion i
            INNER JOIN curso c ON i.id_curso = c.id
            WHERE i.dni_estudiante = ? AND i.calificacion IS NOT NULL
        ");
        $stmt->execute([$dniEstudiante]);
        $registros = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return array_map(function (array $registro) {
            $calificacion = $this->formatearEntradaCalificacion($registro['calificacion'], $registro['fecha_calificacion'] ?? null);
            $registro['calificaciones'] = [$calificacion];
            $registro['calificacion'] = $calificacion['valor'];
            unset($registro['fecha_calificacion']);
            return $registro;
        }, $registros);
    }

    // Guardar o actualizar una nota
    public function guardarNota($dniEstudiante, $idCurso, $nota)
    {
        $stmt = $this->pdo->prepare("
            UPDATE inscripcion
            SET calificacion = ?, fecha_calificacion = NOW()
            WHERE dni_estudiante = ? AND id_curso = ?
        ");
        $resultado = $stmt->execute([$nota, $dniEstudiante, $idCurso]);

        if (!$resultado || $stmt->rowCount() === 0) {
            return false;
        }

        if ($this->tieneTablaCalificaciones()) {
            $inscripcionId = $this->obtenerIdInscripcion($dniEstudiante, $idCurso);
            if ($inscripcionId !== null) {
                try {
                    $insert = $this->pdo->prepare("
                        INSERT INTO inscripcion_calificaciones (inscripcion_id, calificacion, fecha_registro)
                        VALUES (?, ?, NOW())
                    ");
                    $insert->execute([$inscripcionId, $nota]);
                    $this->actualizarCalificacionActualPorInscripcion($inscripcionId);
                } catch (PDOException $e) {
                    if ($e->getCode() === '42P01') {
                        $this->tablaCalificacionesDisponible = false;
                    } else {
                        throw $e;
                    }
                }
            }
        }

        return true;
    }

    public function obtenerHistorialCalificaciones($dniEstudiante)
    {
        if (!$this->tieneTablaCalificaciones()) {
            return [];
        }

        $stmt = $this->pdo->prepare("
            SELECT
                ic.id,
                ic.calificacion,
                ic.fecha_registro,
                to_char(ic.fecha_registro, 'DD/MM/YYYY') AS fecha_formateada,
                c.nombre AS materia,
                ic.inscripcion_id
            FROM inscripcion i
            INNER JOIN curso c ON c.id = i.id_curso
            INNER JOIN inscripcion_calificaciones ic ON ic.inscripcion_id = i.id
            WHERE i.dni_estudiante = ?
            ORDER BY c.nombre, ic.fecha_registro
        ");
        $stmt->execute([$dniEstudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function editarCalificacion($calificacionId, $nuevoValor)
    {
        if (!$this->tieneTablaCalificaciones()) {
            return false;
        }

        $inscripcionId = $this->obtenerInscripcionIdDesdeCalificacion($calificacionId);
        if ($inscripcionId === null) {
            return false;
        }

        $stmt = $this->pdo->prepare('UPDATE inscripcion_calificaciones SET calificacion = ?, fecha_registro = NOW() WHERE id = ?');
        $actualizado = $stmt->execute([$nuevoValor, $calificacionId]);

        if ($actualizado) {
            $this->actualizarCalificacionActualPorInscripcion($inscripcionId);
        }

        return $actualizado;
    }

    public function eliminarCalificacion($calificacionId)
    {
        if (!$this->tieneTablaCalificaciones()) {
            return false;
        }

        $inscripcionId = $this->obtenerInscripcionIdDesdeCalificacion($calificacionId);
        if ($inscripcionId === null) {
            return false;
        }

        $stmt = $this->pdo->prepare('DELETE FROM inscripcion_calificaciones WHERE id = ?');
        $borrado = $stmt->execute([$calificacionId]);

        if ($borrado) {
            $this->actualizarCalificacionActualPorInscripcion($inscripcionId);
        }

        return $borrado;
    }

    public function buscarInscripciones($dni, $materia)
    {
        $query = "
            SELECT i.id, i.dni_estudiante as dni, e.nombre, e.apellido, c.nombre as curso
            FROM inscripcion i
            INNER JOIN estudiante e ON i.dni_estudiante = e.dni
            INNER JOIN curso c ON i.id_curso = c.id
            WHERE i.dni_estudiante = :dni
        ";

        $params = ['dni' => $dni];

        if (!empty($materia)) {
            $query .= " AND c.nombre ILIKE :materia";
            $params['materia'] = "%$materia%";
        }

        $query .= " ORDER BY e.apellido, e.nombre";

        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerBoletinCompleto($dniEstudiante)
    {
        return $this->obtenerNotasPorDNI($dniEstudiante);
    }

    private function tieneTablaCalificaciones(): bool
    {
        if ($this->tablaCalificacionesDisponible !== null) {
            return $this->tablaCalificacionesDisponible;
        }

        try {
            $this->pdo->query('SELECT 1 FROM inscripcion_calificaciones LIMIT 1');
            $this->tablaCalificacionesDisponible = true;
        } catch (PDOException $e) {
            if ($e->getCode() === '42P01') {
                $this->tablaCalificacionesDisponible = false;
            } else {
                throw $e;
            }
        }

        return $this->tablaCalificacionesDisponible;
    }

    private function obtenerIdInscripcion($dniEstudiante, $idCurso)
    {
        $stmt = $this->pdo->prepare('SELECT id FROM inscripcion WHERE dni_estudiante = ? AND id_curso = ?');
        $stmt->execute([$dniEstudiante, $idCurso]);
        $resultado = $stmt->fetchColumn();

        return $resultado !== false ? (int) $resultado : null;
    }

    private function obtenerInscripcionIdDesdeCalificacion($calificacionId)
    {
        $stmt = $this->pdo->prepare('SELECT inscripcion_id FROM inscripcion_calificaciones WHERE id = ?');
        $stmt->execute([$calificacionId]);
        $inscripcionId = $stmt->fetchColumn();

        return $inscripcionId !== false ? (int) $inscripcionId : null;
    }

    private function actualizarCalificacionActualPorInscripcion($inscripcionId)
    {
        $stmt = $this->pdo->prepare('SELECT calificacion, fecha_registro FROM inscripcion_calificaciones WHERE inscripcion_id = ? ORDER BY fecha_registro DESC LIMIT 1');
        $stmt->execute([$inscripcionId]);
        $registro = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($registro) {
            $update = $this->pdo->prepare('UPDATE inscripcion SET calificacion = ?, fecha_calificacion = ? WHERE id = ?');
            $update->execute([$registro['calificacion'], $registro['fecha_registro'], $inscripcionId]);
        } else {
            $update = $this->pdo->prepare('UPDATE inscripcion SET calificacion = NULL, fecha_calificacion = NULL WHERE id = ?');
            $update->execute([$inscripcionId]);
        }
    }

    private function formatearEntradaCalificacion($valor, $fecha)
    {
        $valorCadena = is_numeric($valor) ? rtrim(rtrim((string) $valor, '0'), '.') : (string) $valor;
        $fechaOriginal = $fecha;
        $fechaFormateada = null;

        if (!empty($fechaOriginal)) {
            try {
                $fechaFormateada = (new DateTime($fechaOriginal))->format('d/m/Y');
            } catch (Exception $e) {
                $fechaFormateada = $fechaOriginal;
            }
        }

        return [
            'valor' => $valorCadena,
            'fecha' => $fechaOriginal,
            'fecha_formateada' => $fechaFormateada,
        ];
    }

    private function unirValoresCalificaciones(array $calificaciones): string
    {
        if (empty($calificaciones)) {
            return '';
        }

        $valores = array_map(function (array $entrada) {
            if (!empty($entrada['fecha_formateada'])) {
                return $entrada['valor'] . ' (' . $entrada['fecha_formateada'] . ')';
            }
            return $entrada['valor'];
        }, $calificaciones);

        return implode(' / ', $valores);
    }
}
