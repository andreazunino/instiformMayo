<?php
require_once '../../sql/db.php';
require_once '../../models/Inscripcion.php';
require_once '../../models/Curso.php';
require_once '../../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$inscripcionModel = new Inscripcion($pdo);
$cursoModel = new Curso($pdo);

$dniEstudiante = $_POST['dni'] ?? $_POST['dniEstudiante'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Si viene la solicitud de inscripción
    if (isset($_POST['accion']) && $_POST['accion'] === 'inscribir' && isset($_POST['idCurso'], $_POST['dniEstudiante'])) {
        $idCurso = $_POST['idCurso'];

        $exito = $inscripcionModel->inscribir($dniEstudiante, $idCurso);
        if ($exito) {
            $smarty->assign('mensaje', "Estudiante inscrito correctamente.");
            $smarty->assign('mensaje_tipo', "success");
        } else {
            $smarty->assign('mensaje', "Error al inscribir. Posiblemente ya esté inscrito.");
            $smarty->assign('mensaje_tipo', "danger");
        }
    }

    // Si viene el DNI para buscar cursos
    if ($dniEstudiante) {
        $cursos = $inscripcionModel->cursosDisponiblesParaEstudiante($dniEstudiante);

        if (count($cursos) > 0) {
            $smarty->assign('cursos', $cursos);
        } else {
            $smarty->assign('mensaje', 'No hay cursos disponibles para este estudiante.');
            $smarty->assign('mensaje_tipo', 'warning');
        }

        $smarty->assign('dniEstudiante', $dniEstudiante);
    }
}

$smarty->display('../../templates/inscribirEstudiante.tpl');
