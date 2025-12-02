<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/auth.php';

requireLogin(['admin']);

$inscripcionModel = new Inscripcion($pdo);
$inscripciones = $inscripcionModel->listarInscripciones();

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="inscripciones.csv"');

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
