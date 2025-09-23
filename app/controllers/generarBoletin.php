<?php
require_once __DIR__ . '/../../config/constants.php';
require_once APP_ROOT . '/sql/db.php';
require_once APP_ROOT . '/app/models/Inscripcion.php';
require_once APP_ROOT . '/app/services/BoletinPdf.php';

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

$inscripcionModel = new Inscripcion($pdo);
$notas = $inscripcionModel->obtenerNotasPorDNI($dni);

$pdf = new BoletinPdf();
$pdf->AddPage();
$pdf->renderEncabezadoEstudiante($estudiante, $dni);

if (!$notas) {
    $pdf->renderMensajeSinNotas('Este estudiante aún no tiene calificaciones registradas.');
    $pdf->Output('I', 'Boletin_' . $dni . '.pdf');
    exit;
}

$pdf->renderTablaNotas($notas);
$pdf->Output('I', 'Boletin_' . $dni . '.pdf');
exit;
