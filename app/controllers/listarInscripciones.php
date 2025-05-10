<?php
require_once '../../sql/db.php';
require_once '../../models/Inscripcion.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$inscripcionModel = new Inscripcion($pdo);

// Obtener todas las inscripciones
$inscripciones = $inscripcionModel->listarInscripciones();

if (count($inscripciones) > 0) {
    $smarty->assign('inscripciones', $inscripciones);
} else {
    $smarty->assign('mensaje', 'No hay inscripciones registradas.');
    $smarty->assign('mensaje_tipo', 'info');
}

$smarty->display('../../templates/listarInscripciones.tpl');
