<?php
require_once '../../sql/db.php';
require_once '../../models/Curso.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$cursoModel = new Curso($pdo);

// Obtener lista de cursos para el select
$cursos = $cursoModel->listarTodos();
$smarty->assign('cursos', $cursos);

// Si viene el formulario de modificación
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['curso'], $_POST['nombreCurso'], $_POST['cupo'])) {
    $idCurso = $_POST['curso'];
    $nuevoNombre = $_POST['nombreCurso'];
    $nuevoCupo = $_POST['cupo'];

    if (!empty($nuevoNombre) && !empty($nuevoCupo)) {
        $exito = $cursoModel->modificar($idCurso, $nuevoNombre, $nuevoCupo);
        if ($exito) {
            $smarty->assign('mensaje', 'Curso modificado correctamente.');
            $smarty->assign('mensaje_tipo', 'success');
        } else {
            $smarty->assign('mensaje', 'No se pudo modificar el curso.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    } else {
        $smarty->assign('mensaje', 'Debe completar todos los campos.');
        $smarty->assign('mensaje_tipo', 'warning');
    }

    // Para mantener la selección en el <select>
    $smarty->assign('cursoSeleccionado', $idCurso);
}

$smarty->display('../../templates/modificarDatosCurso.tpl');
