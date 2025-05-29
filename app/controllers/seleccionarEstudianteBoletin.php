<?php

require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../lib/fpdf/fpdf.php'; // Si vas a generar PDF después

require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$estudianteModel = new Estudiante($pdo);
$inscripcionModel = new Inscripcion($pdo);

// Mostrar el formulario para seleccionar estudiante
$estudiantes = $estudianteModel->listarTodos();
$smarty->assign('estudiantes', $estudiantes);

$smarty->display('seleccionarEstudianteBoletin.tpl');

