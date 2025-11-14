<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Inscripcion.php';
require_once __DIR__ . '/../models/Estudiante.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');
$inscripcionModel = new Inscripcion($pdo);
$estudianteModel = new Estudiante($pdo);

// Obtener el DNI del formulario si viene
$dniEstudiante = $_POST['dni_estudiante'] ?? null;
$cursos = [];
$historial = [];
$estudiante = null;
$mensaje = null;
$mensajeTipo = null;

if ($dniEstudiante) {
    $estudiante = $estudianteModel->obtenerPorDNI($dniEstudiante);
    if (!$estudiante) {
        $mensaje = 'No se encontró un estudiante con ese DNI.';
        $mensajeTipo = 'warning';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!$dniEstudiante) {
        $mensaje = 'Ingresá un DNI válido para continuar.';
        $mensajeTipo = 'warning';
    } elseif (!$estudiante && !isset($_POST['buscar_dni'])) {
        $mensaje = 'No se encontró un estudiante con ese DNI.';
        $mensajeTipo = 'warning';
    } elseif (isset($_POST['ingresar_nota']) && $estudiante) {
        $idCurso = $_POST['id_curso'];
        $nota = $_POST['nota'];

        if (!is_numeric($nota) || $nota < 1 || $nota > 10) {
            $mensaje = 'La nota debe ser un número entre 1 y 10.';
            $mensajeTipo = 'warning';
        } else {
            $exito = $inscripcionModel->guardarNota($dniEstudiante, $idCurso, $nota);

            if ($exito) {
                $mensaje = 'Nota guardada correctamente.';
                $mensajeTipo = 'success';
            } else {
                $mensaje = 'No se pudo guardar la nota.';
                $mensajeTipo = 'danger';
            }
        }
    } elseif (isset($_POST['editar_calificacion']) && $estudiante) {
        $calificacionId = $_POST['calificacion_id'] ?? null;
        $nuevoValor = $_POST['nota'] ?? null;

        if (!is_numeric($nuevoValor) || $nuevoValor < 1 || $nuevoValor > 10) {
            $mensaje = 'La nota editada debe ser un número entre 1 y 10.';
            $mensajeTipo = 'warning';
        } else {
            $exito = $inscripcionModel->editarCalificacion($calificacionId, $nuevoValor);
            if ($exito) {
                $mensaje = 'Calificación actualizada.';
                $mensajeTipo = 'success';
            } else {
                $mensaje = 'No se pudo actualizar la calificación.';
                $mensajeTipo = 'danger';
            }
        }
    } elseif (isset($_POST['eliminar_calificacion']) && $estudiante) {
        $calificacionId = $_POST['calificacion_id'] ?? null;
        $exito = $inscripcionModel->eliminarCalificacion($calificacionId);
        if ($exito) {
            $mensaje = 'Calificación eliminada.';
            $mensajeTipo = 'success';
        } else {
            $mensaje = 'No se pudo eliminar la calificación.';
            $mensajeTipo = 'danger';
        }
    }
}

if ($dniEstudiante && $estudiante) {
    $cursos = $inscripcionModel->obtenerCursosPorDNI($dniEstudiante);
    $historial = $inscripcionModel->obtenerHistorialCalificaciones($dniEstudiante);
    if (!empty($historial)) {
        $historial = array_map(function ($registro) {
            if (isset($registro['calificacion'])) {
                $registro['calificacion'] = (int) $registro['calificacion'];
            }
            return $registro;
        }, $historial);
    }

    if (isset($_POST['buscar_dni']) && count($cursos) === 0 && $mensaje === null) {
        $mensaje = 'Este estudiante no está inscrito en ningún curso.';
        $mensajeTipo = 'info';
    }
}

$smarty->assign('dniEstudiante', $dniEstudiante);
$smarty->assign('cursos', $cursos);
$smarty->assign('historial', $historial);
$smarty->assign('estudiante', $estudiante);

if ($mensaje !== null) {
    $smarty->assign('mensaje', $mensaje);
    $smarty->assign('mensaje_tipo', $mensajeTipo ?? 'info');
}

$smarty->display('notas.tpl');
