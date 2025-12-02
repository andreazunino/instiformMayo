<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function loginUser(array $user): void
{
    $_SESSION['user'] = [
        'id' => $user['id'] ?? null,
        'username' => $user['username'] ?? '',
        'role' => $user['role'] ?? $user['rol'] ?? '',
        'dni' => $user['dni'] ?? null,
        'nombre' => $user['nombre'] ?? null,
        'apellido' => $user['apellido'] ?? null,
    ];
}

function logoutUser(): void
{
    $_SESSION = [];

    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params['path'],
            $params['domain'],
            $params['secure'],
            $params['httponly']
        );
    }

    session_destroy();
}

function requireLogin(array $roles = [], string $redirect = '../../index.php'): void
{
    if (!isset($_SESSION['user'])) {
        header("Location: {$redirect}");
        exit;
    }

    if (!empty($roles)) {
        $role = $_SESSION['user']['role'] ?? null;
        if (!in_array($role, $roles, true)) {
            http_response_code(403);
            echo 'Acceso no autorizado.';
            exit;
        }
    }
}

function redirectToDashboard(array $user): void
{
    $role = $user['role'] ?? $user['rol'] ?? null;

    if ($role === 'admin') {
        header('Location: app/controllers/menuAdministrador.php');
    } elseif ($role === 'estudiante') {
        header('Location: app/controllers/menuEstudiante.php');
    } else {
        header('Location: index.php');
    }
    exit;
}
