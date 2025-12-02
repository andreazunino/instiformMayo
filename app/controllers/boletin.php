<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;

$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);

requireLogin(['estudiante', 'admin']);
$usuario = currentUser();
$smarty->assign('usuario', $usuario);

$dniEstudiante = $_POST['dni'] ?? $_GET['dni'] ?? ($usuario['dni'] ?? null);
$smarty->assign('dniEstudiante', $dniEstudiante);

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
