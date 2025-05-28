<?php

class Inscripcion
{
    private $pdo;

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

    // Obtener las notas del boletín de un estudiante
    public function obtenerNotasPorDNI($dniEstudiante)
    {
        $stmt = $this->pdo->prepare("
            SELECT c.nombre AS materia, i.calificacion
            FROM inscripcion i
            INNER JOIN curso c ON i.id_curso = c.id
            WHERE i.dni_estudiante = ? AND i.calificacion IS NOT NULL
        ");
        $stmt->execute([$dniEstudiante]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Guardar o actualizar una nota
    public function guardarNota($dniEstudiante, $idCurso, $nota)
    {
        $stmt = $this->pdo->prepare("
            UPDATE inscripcion
            SET calificacion = ?, fecha_calificacion = NOW()
            WHERE dni_estudiante = ? AND id_curso = ?
        ");
        return $stmt->execute([$nota, $dniEstudiante, $idCurso]);
    }
}
