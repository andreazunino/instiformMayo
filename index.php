<?php
require_once __DIR__ . '/sql/db.php';
require_once __DIR__ . '/app/lib/Smarty/libs/Smarty.class.php';
require_once __DIR__ . '/app/models/Usuario.php';
require_once __DIR__ . '/app/lib/auth.php';

$smarty = new Smarty\Smarty;
$smarty->setTemplateDir(__DIR__ . '/app/views/');
$smarty->setCompileDir(__DIR__ . '/app/templates_c/');

$loginError = null;

$usuarioActual = currentUser();
if ($usuarioActual) {
    redirectToDashboard($usuarioActual);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($username !== '' && $password !== '') {
        $usuarioModel = new Usuario($pdo);
        $usuario = $usuarioModel->validarCredenciales($username, $password);

        if ($usuario) {
            loginUser($usuario);
            redirectToDashboard($usuario);
        } else {
            $loginError = 'Usuario o contrasena incorrectos.';
        }
    } else {
        $loginError = 'Completa usuario y contrasena.';
    }
}

if (isset($_GET['logged_out'])) {
    $loginError = 'Sesion cerrada correctamente.';
}

$smarty->assign('loginError', $loginError);
$smarty->display('index.tpl');
