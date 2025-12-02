<?php

class MetricsService
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function obtenerBasicas(): array
    {
        $metricas = [
            'estudiantes' => 0,
            'cursos' => 0,
            'inscripciones' => 0,
            'promedio_general' => null,
        ];

        $metricas['estudiantes'] = (int) $this->pdo->query('SELECT COUNT(*) FROM estudiante')->fetchColumn();
        $metricas['cursos'] = (int) $this->pdo->query('SELECT COUNT(*) FROM curso')->fetchColumn();
        $metricas['inscripciones'] = (int) $this->pdo->query('SELECT COUNT(*) FROM inscripcion')->fetchColumn();

        $stmt = $this->pdo->query('SELECT AVG(calificacion) FROM inscripcion WHERE calificacion IS NOT NULL');
        $metricas['promedio_general'] = $stmt->fetchColumn();

        return $metricas;
    }
}
