<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');
$inscripcionModel = new Inscripcion($pdo);

// Obtener el DNI del formulario si viene
$dniEstudiante = $_POST['dni_estudiante'] ?? null;
$cursos = [];
$historial = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ingresar_nota'])) {
        $idCurso = $_POST['id_curso'];
        $nota = $_POST['nota'];

        if (!is_numeric($nota) || $nota < 1 || $nota > 10) {
            $smarty->assign('mensaje', 'La nota debe ser un número entre 1 y 10.');
            $smarty->assign('mensaje_tipo', 'warning');
        } else {
            $exito = $inscripcionModel->guardarNota($dniEstudiante, $idCurso, $nota);

            if ($exito) {
                $smarty->assign('mensaje', 'Nota guardada correctamente.');
                $smarty->assign('mensaje_tipo', 'success');
            } else {
                $smarty->assign('mensaje', 'No se pudo guardar la nota.');
                $smarty->assign('mensaje_tipo', 'danger');
            }
        }
    } elseif (isset($_POST['editar_calificacion'])) {
        $calificacionId = $_POST['calificacion_id'] ?? null;
        $nuevoValor = $_POST['nota'] ?? null;

        if (!is_numeric($nuevoValor) || $nuevoValor < 1 || $nuevoValor > 10) {
            $smarty->assign('mensaje', 'La nota editada debe ser un número entre 1 y 10.');
            $smarty->assign('mensaje_tipo', 'warning');
        } else {
            $exito = $inscripcionModel->editarCalificacion($calificacionId, $nuevoValor);
            if ($exito) {
                $smarty->assign('mensaje', 'Calificación actualizada.');
                $smarty->assign('mensaje_tipo', 'success');
            } else {
                $smarty->assign('mensaje', 'No se pudo actualizar la calificación.');
                $smarty->assign('mensaje_tipo', 'danger');
            }
        }
    } elseif (isset($_POST['eliminar_calificacion'])) {
        $calificacionId = $_POST['calificacion_id'] ?? null;
        $exito = $inscripcionModel->eliminarCalificacion($calificacionId);
        if ($exito) {
            $smarty->assign('mensaje', 'Calificación eliminada.');
            $smarty->assign('mensaje_tipo', 'success');
        } else {
            $smarty->assign('mensaje', 'No se pudo eliminar la calificación.');
            $smarty->assign('mensaje_tipo', 'danger');
        }
    } elseif (isset($_POST['buscar_dni'])) {
        // no action beyond refresh
    }
}

if ($dniEstudiante) {
    $cursos = $inscripcionModel->obtenerCursosPorDNI($dniEstudiante);
    $historial = $inscripcionModel->obtenerHistorialCalificaciones($dniEstudiante);

    if (isset($_POST['buscar_dni']) && count($cursos) === 0) {
        $smarty->assign('mensaje', 'Este estudiante no está inscrito en ningún curso.');
        $smarty->assign('mensaje_tipo', 'info');
    }
}

$smarty->assign('dniEstudiante', $dniEstudiante);
$smarty->assign('cursos', $cursos);
$smarty->assign('historial', $historial);

$smarty->display('notas.tpl');
