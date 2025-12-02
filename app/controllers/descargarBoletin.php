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
$firmaNombre = $_GET['firma'] ?? 'Pedro Emith';
$firmaCargo = $_GET['cargo'] ?? 'Director';
$firmaPath = APP_SIGNATURE_PATH;

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
$pdf->setFirma($firmaNombre, $firmaCargo, $firmaPath);
$pdf->AddPage();
$pdf->renderEncabezadoEstudiante($estudiante, $dniEstudiante);

if (!empty($notas)) {
    $pdf->renderTablaNotas($notas);
} else {
    $pdf->renderMensajeSinNotas("Este estudiante aun no tiene calificaciones registradas.\n\nEste boletin ha sido generado unicamente como documento informativo.");
}

$pdf->renderSeccionFirma();
$pdf->Output('D', 'Boletin_' . $dniEstudiante . '.pdf');
exit;
