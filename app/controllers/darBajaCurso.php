<?php
require_once '../../sql/db.php';
require_once '../../models/Curso.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$cursoModel = new Curso($pdo);

// Listar todos los cursos para el <select>
$cursos = $cursoModel->listarTodos();
$smarty->assign('cursos', $cursos);

// Si se envía el formulario de baja
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['curso'])) {
    $idCurso = $_POST['curso'];

    // Intentar eliminar el curso
    $exito = $cursoModel->eliminar($idCurso);

    if ($exito) {
        $mensaje = "Curso eliminado correctamente.";
        $mensaje_tipo = "success";
    } else {
        $mensaje = "Error al eliminar el curso. Verifica si tiene inscripciones asociadas.";
        $mensaje_tipo = "danger";
    }

    // Volver a listar cursos actualizados
    $cursos = $cursoModel->listarTodos();
    $smarty->assign('cursos', $cursos);
    $smarty->assign('mensaje', $mensaje);
    $smarty->assign('mensaje_tipo', $mensaje_tipo);
}

$smarty->display('../../templates/darBajaCurso.tpl');
