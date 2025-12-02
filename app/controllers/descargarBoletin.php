<?php
require_once __DIR__ . '/../../config/constants.php';
require_once APP_ROOT . '/sql/db.php';
require_once APP_ROOT . '/app/models/Inscripcion.php';
require_once APP_ROOT . '/app/services/BoletinPdf.php';
require_once APP_ROOT . '/app/lib/auth.php';

$inscripcionModel = new Inscripcion($pdo);
requireLogin(['admin', 'estudiante']);

$desde = $_GET['desde'] ?? null;
$hasta = $_GET['hasta'] ?? null;
$firmaNombre = $_GET['firma'] ?? null;
$firmaCargo = $_GET['cargo'] ?? null;

$dniEstudiante = $_GET['dni'] ?? null;
if (!$dniEstudiante) {
    die('DNI no especificado.');
}

$stmt = $pdo->prepare('SELECT nombre, apellido FROM estudiante WHERE dni = ?');
$stmt->execute([$dniEstudiante]);
$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$estudiante) {
    die('Estudiante no encontrado.');
}

$notas = $inscripcionModel->obtenerNotasPorDNI($dniEstudiante, $desde, $hasta);

$pdf = new BoletinPdf();
$pdf->setPeriodo($desde, $hasta);
$pdf->setFirma($firmaNombre, $firmaCargo);
$pdf->AddPage();
$pdf->renderEncabezadoEstudiante($estudiante, $dniEstudiante);

if (!empty($notas)) {
    $pdf->renderTablaNotas($notas);
} else {
    $pdf->renderMensajeSinNotas("Este estudiante aún no tiene calificaciones registradas.

Este boletín ha sido generado únicamente como documento informativo.");
}

$pdf->Output('D', 'Boletin_' . $dniEstudiante . '.pdf');
exit;
