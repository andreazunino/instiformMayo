<?php
require_once '../../sql/db.php';
require_once '../../models/Estudiante.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$estudianteModel = new Estudiante($pdo);

// Obtener todos los estudiantes para el <select>
$estudiantes = $estudianteModel->listarTodos();
$smarty->assign('estudiantes', $estudiantes);

$smarty->display('../../templates/seleccionarEstudianteBoletin.tpl');
