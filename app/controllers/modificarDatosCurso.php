<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../models/Curso.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../lib/auth.php';


$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');
$cursoModel = new Curso($pdo);

requireLogin(['admin']);
// Obtener lista de cursos para el select
$cursos = $cursoModel->listarTodos();
$smarty->assign('cursos', $cursos);

// Si viene el formulario de modificacion
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

    // Para mantener la selección en el select
    $smarty->assign('cursoSeleccionado', $idCurso);
}

$smarty->display('modificarDatosCurso.tpl');
