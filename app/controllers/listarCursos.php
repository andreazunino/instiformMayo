<?php

require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$cursoModel = new Curso($pdo);
requireLogin(['admin']);
$cursos = [];
$nombreCurso = '';
$mensaje = null;
$mensaje_tipo = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['accion']) && $_POST['accion'] === 'buscar') {
    $nombreCurso = trim($_POST['nombreCurso'] ?? '');

    if (!empty($nombreCurso)) {
        $cursos = $cursoModel->buscarPorNombre($nombreCurso);

        if (count($cursos) === 0) {
            $mensaje = 'No se encontraron cursos con ese nombre.';
            $mensaje_tipo = 'info';
        }
    } else {
        $mensaje = 'Por favor, ingrese un nombre para buscar.';
        $mensaje_tipo = 'warning';
    }
} else {
    // Si no se hace búsqueda, mostrar todos los cursos
    $cursos = $cursoModel->listarTodos();
}

// Asignar variables a Smarty
$smarty->assign('cursos', $cursos);
$smarty->assign('nombreCurso', $nombreCurso);
$smarty->assign('mensaje', $mensaje);
$smarty->assign('mensaje_tipo', $mensaje_tipo);

// Mostrar plantilla
$smarty->display('listarCursos.tpl');
