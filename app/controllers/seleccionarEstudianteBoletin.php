<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$estudianteModel = new Estudiante($pdo);
$inscripcionModel = new Inscripcion($pdo);

requireLogin(['admin']);

$estudiantes = $estudianteModel->listarTodos();
$smarty->assign('estudiantes', $estudiantes);

$smarty->display('seleccionarEstudianteBoletin.tpl');

