<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../lib/auth.php';

requireLogin(['admin']);

$cursoModel = new Curso($pdo);
$cursos = $cursoModel->listarTodos();

header('Content-Type: text/csv; charset=UTF-8');
header('Content-Disposition: attachment; filename="cursos.csv"');

$out = fopen('php://output', 'w');
fputcsv($out, ['ID', 'Nombre', 'Cupo']);

foreach ($cursos as $curso) {
    fputcsv($out, [$curso['id'], $curso['nombre'], $curso['cupo']]);
}

fclose($out);
exit;
