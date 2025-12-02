<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$inscripcionModel = new Inscripcion($pdo);
requireLogin(['admin']);

// Obtener todas las inscripciones
$inscripciones = $inscripcionModel->listarInscripciones();

if (count($inscripciones) > 0) {
    $smarty->assign('inscripciones', $inscripciones);
} else {
    $smarty->assign('mensaje', 'No hay inscripciones registradas.');
    $smarty->assign('mensaje_tipo', 'info');
}

$smarty->display('listarInscripciones.tpl');
