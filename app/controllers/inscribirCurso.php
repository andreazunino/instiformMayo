<?php
require_once '../../sql/db.php';
require_once '../../models/Inscripcion.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$inscripcionModel = new Inscripcion($pdo);

$dniEstudiante = $_POST['dni'] ?? $_POST['dniEstudiante'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Inscripción del curso
    if (isset($_POST['idCurso'], $_POST['dniEstudiante'])) {
        $idCurso = $_POST['idCurso'];

        $exito = $inscripcionModel->inscribir($dniEstudiante, $idCurso);
        if ($exito) {
            $smarty->assign('mensaje', 'Te inscribiste correctamente al curso.');
            $smarty->assign('mensaje_tipo', 'success');
        } else {
            $smarty->assign('mensaje', 'No se pudo realizar la inscripción.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    }

    // Buscar cursos disponibles para ese estudiante
    if ($dniEstudiante) {
        $cursos = $inscripcionModel->cursosDisponiblesParaEstudiante($dniEstudiante);

        if (count($cursos) > 0) {
            $smarty->assign('cursos', $cursos);
        } else {
            $smarty->assign('mensaje', 'No hay cursos disponibles para tu inscripción.');
            $smarty->assign('mensaje_tipo', 'warning');
        }

        $smarty->assign('dniEstudiante', $dniEstudiante);
    }
}

$smarty->display('../../templates/inscribirCurso.tpl');
