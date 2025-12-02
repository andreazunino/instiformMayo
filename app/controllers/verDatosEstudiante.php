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

try {
    $estudiantes = $estudianteModel->listarTodos();

    if (count($estudiantes) > 0) {
        $smarty->assign('estudiantes', $estudiantes);
    } else {
        $smarty->assign('mensaje', 'No hay estudiantes registrados.');
        $smarty->assign('mensaje_tipo', 'info');
    }

} catch (Exception $e) {
    $smarty->assign('mensaje', 'Error al obtener estudiantes: ' . $e->getMessage());
    $smarty->assign('mensaje_tipo', 'danger');
}

$smarty->display('verDatosEstudiante.tpl');
