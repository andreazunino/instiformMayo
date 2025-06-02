<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$cursoModel = new Curso($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['accion'] === 'alta') {
    $nombre = $_POST['nombre'] ?? '';
    $cupo = $_POST['cupo'] ?? null;

    if (!empty($nombre) && !empty($cupo)) {
        $resultado = $cursoModel->crear($nombre, $cupo);
        if ($resultado) {
            $smarty->assign('mensaje', 'El curso fue creado exitosamente.');
        } else {
            $smarty->assign('error', 'Ocurrió un error al crear el curso.');
        }
    } else {
        $smarty->assign('error', 'Todos los campos son obligatorios.');
    }
}

$smarty->display('darAltaCurso.tpl');
