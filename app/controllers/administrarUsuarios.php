<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/../models/Usuario.php';
require_once __DIR__ . '/../lib/auth.php';

requireLogin(['admin']);

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/../views/');
$smarty->setCompileDir(__DIR__ . '/../templates_c/');

$usuarioModel = new Usuario($pdo);
$mensaje = null;
$mensaje_tipo = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $role = $_POST['role'] ?? '';
    $nombre = trim($_POST['nombre'] ?? '');
    $apellido = trim($_POST['apellido'] ?? '');
    $dni = trim($_POST['dni'] ?? '');

    if ($username === '' || $password === '' || ($role !== 'admin' && $role !== 'estudiante')) {
        $mensaje = 'Completá usuario, contraseña y rol válido.';
        $mensaje_tipo = 'warning';
    } elseif ($usuarioModel->existeUsername($username)) {
        $mensaje = 'El usuario ya existe.';
        $mensaje_tipo = 'warning';
    } else {
        $ok = $usuarioModel->crear($username, $password, $role, $nombre, $apellido, $dni);
        if ($ok) {
            $mensaje = 'Usuario creado correctamente.';
            $mensaje_tipo = 'success';
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
