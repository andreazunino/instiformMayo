<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../models/Estudiante.php';
require_once __DIR__ . '/../lib/auth.php';

requireLogin(['admin']);

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$usuarioModel = new Usuario($pdo);
$estudianteModel = new Estudiante($pdo);
$mensaje = null;
$mensaje_tipo = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = $_POST['role'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if ($username === '' || $password === '' || ($role !== 'admin' && $role !== 'estudiante')) {
        $mensaje = 'Completa usuario, contrasena y rol valido.';
        $mensaje_tipo = 'warning';
    } elseif ($role === 'estudiante' && $dni === '') {
        $mensaje = 'Para crear un estudiante es necesario completar el DNI.';
        $mensaje_tipo = 'warning';
    } elseif ($usuarioModel->existeUsername($username)) {
        $mensaje = 'El usuario ya existe.';
        $mensaje_tipo = 'warning';
    } else {
        $ok = $usuarioModel->crear($username, $password, $role, $nombre, $apellido, $dni, $email);
        if ($ok) {
            if ($role === 'estudiante' && $dni !== '') {
                // Asegura que el estudiante exista para evitar fallos al inscribirse
                $existeEstudiante = $estudianteModel->obtenerPorDNI($dni);
                if (!$existeEstudiante) {
                    $creadoEstudiante = $estudianteModel->crear(
                        $dni,
                        $nombre !== '' ? $nombre : $username,
                        $apellido !== '' ? $apellido : ' ',
                        $email !== '' ? $email : ($username . '@example.com')
                    );
                    if (!$creadoEstudiante) {
                        $mensaje = 'Usuario creado, pero no se pudo registrar al estudiante.';
                        $mensaje_tipo = 'warning';
                    }
                }
            }
            if ($mensaje === null) {
                $mensaje = 'Usuario creado correctamente.';
                $mensaje_tipo = 'success';
            }
        } else {
            $mensaje = 'No se pudo crear el usuario.';
            $mensaje_tipo = 'danger';
        }
    }
}

$usuarios = $usuarioModel->listarTodos();
$smarty->assign('usuarios', $usuarios);
$smarty->assign('mensaje', $mensaje);
$smarty->assign('mensaje_tipo', $mensaje_tipo);

$smarty->display('administrarUsuarios.tpl');
