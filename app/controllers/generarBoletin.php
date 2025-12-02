<?php
require_once __DIR__ . '/../../config/constants.php';
require_once APP_ROOT . '/sql/db.php';
require_once APP_ROOT . '/app/models/Inscripcion.php';
require_once APP_ROOT . '/app/services/BoletinPdf.php';
require_once APP_ROOT . '/app/lib/auth.php';

$dni = $_GET['dni'] ?? null;

if (!$dni) {
    die('DNI no proporcionado.');
}

$stmt = $pdo->prepare('SELECT nombre, apellido FROM estudiante WHERE dni = ?');
$stmt->execute([$dni]);
$estudiante = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$estudiante) {
    die('Estudiante no encontrado.');
}
$desde = $_GET['desde'] ?? null;
$hasta = $_GET['hasta'] ?? null;
$firmaNombre = $_GET['firma'] ?? 'Pedro Emith';
$firmaCargo = $_GET['cargo'] ?? 'Director';
$firmaPath = APP_SIGNATURE_PATH;

$inscripcionModel = new Inscripcion($pdo);
requireLogin(['admin', 'estudiante']);

$notas = $inscripcionModel->obtenerNotasPorDNI($dni, $desde, $hasta);

$pdf = new BoletinPdf();
$pdf->setPeriodo($desde, $hasta);
$pdf->setFirma($firmaNombre, $firmaCargo, $firmaPath);
$pdf->AddPage();
$pdf->renderEncabezadoEstudiante($estudiante, $dni);

if (!$notas) {
    $pdf->renderMensajeSinNotas('Este estudiante aún no tiene calificaciones registradas.');
    $pdf->Output('I', 'Boletin_' . $dni . '.pdf');
    exit;
}

$pdf->renderTablaNotas($notas);
$pdf->renderSeccionFirma();
$pdf->Output('I', 'Boletin_' . $dni . '.pdf');
exit;
