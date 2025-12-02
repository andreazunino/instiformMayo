<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$estudianteModel = new Estudiante($pdo);

requireLogin(['admin']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $accion = $_POST['accion'] ?? '';

    if ($accion === 'buscar' && !empty($_POST['documento'])) {
        $dni = $_POST['documento'];
        $estudiante = $estudianteModel->obtenerPorDNI($dni);

        if ($estudiante) {
            $smarty->assign('estudiante', $estudiante);
        } else {
            $smarty->assign('mensaje', 'No se encontró un estudiante con ese DNI.');
            $smarty->assign('mensaje_tipo', 'warning');
        }
    }

    if ($accion === 'eliminar' && !empty($_POST['dni_estudiante'])) {
        $dni = $_POST['dni_estudiante'];
        $exito = $estudianteModel->eliminar($dni);

        if ($exito) {
            $smarty->assign('mensaje', 'El estudiante fue eliminado exitosamente.');
            $smarty->assign('mensaje_tipo', 'success');
        } else {
            $smarty->assign('mensaje', 'No se pudo eliminar al estudiante.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    }
}

$smarty->display('bajaEstudiante.tpl');
