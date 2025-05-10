<?php
require_once '../../sql/db.php';
require_once '../../models/Inscripcion.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$inscripcionModel = new Inscripcion($pdo);

$dniEstudiante = $_POST['dni'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $dniEstudiante) {
    $notas = $inscripcionModel->obtenerNotasPorDNI($dniEstudiante);

    if (count($notas) > 0) {
        $smarty->assign('notas', $notas);
    } else {
        $smarty->assign('mensaje', 'No se encontraron calificaciones para el DNI ingresado.');
        $smarty->assign('mensaje_tipo', 'info');
    }

    $smarty->assign('dniEstudiante', $dniEstudiante);
}

$smarty->display('../../templates/boletin.tpl');
