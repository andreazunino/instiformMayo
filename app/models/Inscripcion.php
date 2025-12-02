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
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("SELECT cupo FROM curso WHERE id = ? FOR UPDATE");
            $stmt->execute([$idCurso]);
            $curso = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$curso || (int) $curso['cupo'] <= 0) {
                $this->pdo->rollBack();
                return false;
            }

            $insert = $this->pdo->prepare("INSERT INTO inscripcion (dni_estudiante, id_curso) VALUES (?, ?)");
            $resultado = $insert->execute([$dniEstudiante, $idCurso]);

            if (!$resultado) {
                $this->pdo->rollBack();
                return false;
            }

            $updateCupo = $this->pdo->prepare("UPDATE curso SET cupo = cupo - 1 WHERE id = ?");
            $updateCupo->execute([$idCurso]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
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

    // Cursos disponibles para un estudiante (que no este inscrito y con cupo)
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

    // Anular inscripcion de un estudiante a un curso
    public function anular($dniEstudiante, $idCurso)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare("DELETE FROM inscripcion WHERE dni_estudiante = ? AND id_curso = ?");
            $stmt->execute([$dniEstudiante, $idCurso]);

            if ($stmt->rowCount() === 0) {
                $this->pdo->rollBack();
                return false;
            }

            $updateCupo = $this->pdo->prepare("UPDATE curso SET cupo = cupo + 1 WHERE id = ?");
            $updateCupo->execute([$idCurso]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
    }

    public function eliminarPorId($inscripcionId)
    {
        try {
            $this->pdo->beginTransaction();

            $stmt = $this->pdo->prepare('SELECT id_curso FROM inscripcion WHERE id = ? FOR UPDATE');
            $stmt->execute([$inscripcionId]);
            $registro = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$registro) {
                $this->pdo->rollBack();
                return false;
            }

            $delete = $this->pdo->prepare('DELETE FROM inscripcion WHERE id = ?');
            $delete->execute([$inscripcionId]);

            if ($delete->rowCount() === 0) {
                $this->pdo->rollBack();
                return false;
            }

            $updateCupo = $this->pdo->prepare('UPDATE curso SET cupo = cupo + 1 WHERE id = ?');
            $updateCupo->execute([$registro['id_curso']]);

            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->pdo->inTransaction()) {
                $this->pdo->rollBack();
            }
            throw $e;
        }
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
    public function obtenerNotasPorDNI($dniEstudiante, ?string $desde = null, ?string $hasta = null)
    {
        if ($this->tieneTablaCalificaciones()) {
            $filtrosFecha = '';
            $params = [$dniEstudiante];

            if ($desde !== null) {
                $filtrosFecha .= " AND ic.fecha_registro >= ? ";
                $params[] = $desde;
            }

            if ($hasta !== null) {
                $filtrosFecha .= " AND ic.fecha_registro <= ? ";
                $params[] = $hasta;
            }

            $stmt = $this->pdo->prepare("
                SELECT
                    c.nombre AS materia,
                    COALESCE(
                        SUM(ic.calificacion * COALESCE(ic.peso, 1)) / NULLIF(SUM(COALESCE(ic.peso, 1)), 0),
                        i.calificacion
                    ) AS promedio_ponderado,
                    i.fecha_calificacion AS fecha_calificacion_manual,
                    COALESCE(
                        json_agg(
                            json_build_object(
                                'valor', ic.calificacion,
                                'fecha', ic.fecha_registro,
                                'peso', ic.peso,
                                'actividad', ic.actividad,
                                'version', ic.version,
                                'observaciones', ic.observaciones
                            ) ORDER BY ic.fecha_registro
                        ) FILTER (WHERE ic.id IS NOT NULL),
                        '[]'
                    ) AS historial
                FROM inscripcion i
                INNER JOIN curso c ON i.id_curso = c.id
                LEFT JOIN inscripcion_calificaciones ic ON ic.inscripcion_id = i.id {$filtrosFecha}
                WHERE i.dni_estudiante = ?
                  AND (i.calificacion IS NOT NULL OR ic.id IS NOT NULL)
                GROUP BY c.nombre, i.calificacion, i.fecha_calificacion, i.id
                ORDER BY c.nombre
            ");
            $stmt->execute($params);
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
                    $calificaciones[] = $this->formatearEntradaCalificacion(
                        $entrada['valor'],
                        $entrada['fecha'] ?? null,
                        $entrada['peso'] ?? null,
                        $entrada['actividad'] ?? null,
                        $entrada['version'] ?? null,
                        $entrada['observaciones'] ?? null
                    );
                }

                if (empty($calificaciones) && $registro['promedio_ponderado'] !== null) {
                    $calificaciones[] = $this->formatearEntradaCalificacion($registro['promedio_ponderado'], $registro['fecha_calificacion_manual'] ?? null);
                }

                $registro['calificaciones'] = $calificaciones;
                $registro['calificacion'] = $this->unirValoresCalificaciones($calificaciones);
                $registro['promedio'] = $registro['calificacion'];
                unset($registro['historial'], $registro['promedio_ponderado'], $registro['fecha_calificacion_manual']);

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
                        INSERT INTO inscripcion_calificaciones (inscripcion_id, calificacion, fecha_registro, peso, actividad, version)
                        VALUES (?, ?, NOW(), COALESCE(?, 1), ?, COALESCE((SELECT COALESCE(MAX(version),0)+1 FROM inscripcion_calificaciones WHERE inscripcion_id = ?),1))
                    ");
                    $insert->execute([$inscripcionId, $nota, 1, 'Carga manual', $inscripcionId]);
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

    /**
     * Registrar una actividad con peso, nombre y versionado.
     */
    public function registrarActividadCalificacion(
        string $dniEstudiante,
        int $idCurso,
        float $calificacion,
        ?string $actividad = null,
        float $peso = 1.0,
        ?string $observaciones = null,
        ?string $fecha = null
    ): bool {
        if (!$this->tieneTablaCalificaciones()) {
            return false;
        }

        $inscripcionId = $this->obtenerIdInscripcion($dniEstudiante, $idCurso);
        if ($inscripcionId === null) {
            return false;
        }

        $fechaRegistro = $fecha ?? date('Y-m-d H:i:s');
        $actividadNombre = $actividad ?: 'Actividad';
        $pesoNormalizado = ($peso > 0) ? $peso : 1.0;

        $nextVersion = $this->obtenerSiguienteVersion($inscripcionId);

        $stmt = $this->pdo->prepare("
            INSERT INTO inscripcion_calificaciones (inscripcion_id, calificacion, fecha_registro, peso, actividad, version, observaciones)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        $ok = $stmt->execute([
            $inscripcionId,
            $calificacion,
            $fechaRegistro,
            $pesoNormalizado,
            $actividadNombre,
            $nextVersion,
            $observaciones
        ]);

        if ($ok) {
            $this->actualizarCalificacionActualPorInscripcion($inscripcionId);
        }

        return $ok;
    }

    public function obtenerPromedioPorCurso(int $idCurso, ?string $desde = null, ?string $hasta = null): array
    {
        $filtroFecha = '';
        $params = [$idCurso];

        if ($desde !== null) {
            $filtroFecha .= " AND ic.fecha_registro >= ? ";
            $params[] = $desde;
        }
        if ($hasta !== null) {
            $filtroFecha .= " AND ic.fecha_registro <= ? ";
            $params[] = $hasta;
        }

        if (!$this->tieneTablaCalificaciones()) {
            $stmt = $this->pdo->prepare("
                SELECT AVG(calificacion) AS promedio, COUNT(*) AS inscriptos
                FROM inscripcion
                WHERE id_curso = ? AND calificacion IS NOT NULL
            ");
            $stmt->execute([$idCurso]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
            return [
                'promedio' => $row['promedio'] ?? null,
                'inscriptos' => (int) ($row['inscriptos'] ?? 0),
            ];
        }

        $stmt = $this->pdo->prepare("
            SELECT
                AVG(promedio_ponderado) AS promedio,
                COUNT(*) AS inscriptos
            FROM (
                SELECT
                    i.id,
                    COALESCE(
                        SUM(ic.calificacion * COALESCE(ic.peso,1)) / NULLIF(SUM(COALESCE(ic.peso,1)),0),
                        i.calificacion
                    ) AS promedio_ponderado
                FROM inscripcion i
                LEFT JOIN inscripcion_calificaciones ic ON ic.inscripcion_id = i.id {$filtroFecha}
                WHERE i.id_curso = ?
                  AND (i.calificacion IS NOT NULL OR ic.id IS NOT NULL)
                GROUP BY i.id, i.calificacion
            ) t
        ");
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC) ?: [];

        return [
            'promedio' => $row['promedio'] ?? null,
            'inscriptos' => (int) ($row['inscriptos'] ?? 0),
        ];
    }

    public function obtenerActaPorCurso(int $idCurso, ?string $desde = null, ?string $hasta = null): array
    {
        $filtroFecha = '';
        $params = [$idCurso];

        if ($desde !== null) {
            $filtroFecha .= " AND ic.fecha_registro >= ? ";
            $params[] = $desde;
        }
        if ($hasta !== null) {
            $filtroFecha .= " AND ic.fecha_registro <= ? ";
            $params[] = $hasta;
        }

        if (!$this->tieneTablaCalificaciones()) {
            $stmt = $this->pdo->prepare("
                SELECT e.dni, e.apellido, e.nombre, i.calificacion AS promedio, i.fecha_calificacion
                FROM inscripcion i
                INNER JOIN estudiante e ON e.dni = i.dni_estudiante
                WHERE i.id_curso = ? AND i.calificacion IS NOT NULL
                ORDER BY e.apellido, e.nombre
            ");
            $stmt->execute([$idCurso]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        $stmt = $this->pdo->prepare("
            SELECT
                e.dni,
                e.apellido,
                e.nombre,
                COALESCE(
                    SUM(ic.calificacion * COALESCE(ic.peso,1)) / NULLIF(SUM(COALESCE(ic.peso,1)),0),
                    i.calificacion
                ) AS promedio,
                MAX(ic.version) AS version,
                MAX(ic.fecha_registro) AS ultima_actualizacion
            FROM inscripcion i
            INNER JOIN estudiante e ON e.dni = i.dni_estudiante
            LEFT JOIN inscripcion_calificaciones ic ON ic.inscripcion_id = i.id {$filtroFecha}
            WHERE i.id_curso = ?
              AND (i.calificacion IS NOT NULL OR ic.id IS NOT NULL)
            GROUP BY e.dni, e.apellido, e.nombre, i.calificacion, i.id
            ORDER BY e.apellido, e.nombre
        ");
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerHistorialCalificaciones($dniEstudiante, ?string $desde = null, ?string $hasta = null)
    {
        if (!$this->tieneTablaCalificaciones()) {
            return [];
        }

        $filtroFecha = '';
        $params = [$dniEstudiante];
        if ($desde !== null) {
            $filtroFecha .= " AND ic.fecha_registro >= ? ";
            $params[] = $desde;
        }
        if ($hasta !== null) {
            $filtroFecha .= " AND ic.fecha_registro <= ? ";
            $params[] = $hasta;
        }

        $stmt = $this->pdo->prepare("
            SELECT
                ic.id,
                ic.calificacion,
                ic.fecha_registro,
                to_char(ic.fecha_registro, 'DD/MM/YYYY') AS fecha_formateada,
                c.nombre AS materia,
                ic.inscripcion_id,
                ic.peso,
                ic.actividad,
                ic.version,
                ic.observaciones
            FROM inscripcion i
            INNER JOIN curso c ON c.id = i.id_curso
            INNER JOIN inscripcion_calificaciones ic ON ic.inscripcion_id = i.id {$filtroFecha}
            WHERE i.dni_estudiante = ?
            ORDER BY c.nombre, ic.fecha_registro
        ");
        $stmt->execute($params);
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
            SELECT 
                i.id, 
                i.dni_estudiante AS dni, 
                i.dni_estudiante AS dni_estudiante,
                e.nombre, 
                e.apellido, 
                c.nombre AS curso,
                c.nombre AS curso_nombre
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
            $this->asegurarColumnasCalificaciones();
        } catch (PDOException $e) {
            if ($e->getCode() === '42P01') {
                $this->tablaCalificacionesDisponible = $this->crearTablaCalificaciones();
            } else {
                throw $e;
            }
        }

        return $this->tablaCalificacionesDisponible;
    }

    private function crearTablaCalificaciones(): bool
    {
        try {
            $this->pdo->exec("
                CREATE TABLE IF NOT EXISTS inscripcion_calificaciones (
                    id SERIAL PRIMARY KEY,
                    inscripcion_id INTEGER NOT NULL REFERENCES inscripcion(id) ON DELETE CASCADE,
                    calificacion NUMERIC(5,2) NOT NULL,
                    fecha_registro TIMESTAMP WITHOUT TIME ZONE NOT NULL DEFAULT NOW(),
                    peso NUMERIC(5,2) DEFAULT 1,
                    actividad VARCHAR(120),
                    version INTEGER DEFAULT 1,
                    observaciones TEXT
                );
                CREATE INDEX IF NOT EXISTS idx_inscripcion_calificaciones_inscripcion_id
                    ON inscripcion_calificaciones (inscripcion_id);
            ");

            // Asegura columnas nuevas en tablas existentes
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS peso NUMERIC(5,2) DEFAULT 1;");
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS actividad VARCHAR(120);");
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS version INTEGER DEFAULT 1;");
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS observaciones TEXT;");
            return true;
        } catch (PDOException $e) {
            error_log('No se pudo crear la tabla inscripcion_calificaciones: ' . $e->getMessage());
            return false;
        }
    }

    private function asegurarColumnasCalificaciones(): void
    {
        try {
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS peso NUMERIC(5,2) DEFAULT 1;");
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS actividad VARCHAR(120);");
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS version INTEGER DEFAULT 1;");
            $this->pdo->exec("ALTER TABLE inscripcion_calificaciones ADD COLUMN IF NOT EXISTS observaciones TEXT;");
        } catch (PDOException $e) {
            // No interrumpir flujo; solo registrar
            error_log('No se pudieron asegurar columnas de calificaciones: ' . $e->getMessage());
        }
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

    private function obtenerSiguienteVersion(int $inscripcionId): int
    {
        $stmt = $this->pdo->prepare('SELECT COALESCE(MAX(version), 0) + 1 FROM inscripcion_calificaciones WHERE inscripcion_id = ?');
        $stmt->execute([$inscripcionId]);
        return (int) $stmt->fetchColumn();
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

    private function formatearEntradaCalificacion($valor, $fecha, $peso = null, $actividad = null, $version = null, $observaciones = null)
    {
        if (is_numeric($valor)) {
            $valorCadena = (string) $valor;
            if (strpos($valorCadena, '.') !== false) {
                // Remove only trailing zeros from the decimal part, keep integer zeros intact
                $valorCadena = rtrim(rtrim($valorCadena, '0'), '.');
            }
        } else {
            $valorCadena = (string) $valor;
        }
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
            'peso' => $peso,
            'actividad' => $actividad,
            'version' => $version,
            'observaciones' => $observaciones,
        ];
    }

    private function unirValoresCalificaciones(array $calificaciones): string
    {
        if (empty($calificaciones)) {
            return '';
        }

        $valores = array_map(function (array $entrada) {
            $valor = $entrada['valor'];
            if (!empty($entrada['actividad'])) {
                $valor = $entrada['actividad'] . ': ' . $valor;
            }
            if (!empty($entrada['peso'])) {
                $valor .= ' (peso ' . $entrada['peso'] . ')';
            }
            if (!empty($entrada['fecha_formateada'])) {
                $valor .= ' - ' . $entrada['fecha_formateada'];
            }
            return $valor;
        }, $calificaciones);

        return implode(' / ', $valores);
    }
}
