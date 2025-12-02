<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/auth.php';

requireLogin(['admin', 'estudiante']);
$usuario = currentUser();
$rol = $usuario['role'] ?? '';
$dniUsuario = $usuario['dni'] ?? null;

$inscripcionModel = new Inscripcion($pdo);
$inscripciones = [];
$nombreArchivo = 'inscripciones.csv';

if ($rol === 'admin') {
    $inscripciones = $inscripcionModel->listarInscripciones();
} elseif ($rol === 'estudiante') {
    if ($dniUsuario === null) {
        http_response_code(400);
        echo 'No se pudo determinar el DNI del estudiante para generar la descarga.';
        exit;
    }
    $inscripciones = $inscripcionModel->listarInscripcionesPorDni($dniUsuario);
    $nombreArchivo = 'mis_inscripciones.csv';
}

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');

$out = fopen('php://output', 'w');
fputcsv($out, ['ID', 'DNI', 'Nombre', 'Apellido', 'Curso']);

foreach ($inscripciones as $inscripcion) {
    fputcsv($out, [
        $inscripcion['id'],
        $inscripcion['dni'],
        $inscripcion['nombre'],
        $inscripcion['apellido'],
        $inscripcion['curso'],
    ]);
}

fclose($out);
exit;
