<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';

$smarty = new Smarty\Smarty;

$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

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

$smarty->display('boletin.tpl');


