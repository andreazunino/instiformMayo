<?php
/* Smarty version 5.4.0, created on 2025-05-28 14:19:09
  from 'file:index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_6836ff3dbd9e08_32862318',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a1736d6204912ee81c4ec9d3b9f31d5f683d272' => 
    array (
      0 => 'index.tpl',
      1 => 1748174162,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_6836ff3dbd9e08_32862318 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instiform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background: linear-gradient(to bottom, #a1c4fd, #c2e9fb);
            min-height: 100vh;
            margin: 0;
            font-family: 'Arial', sans-serif;
        }
        .container-welcome {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .welcome-heading {
            font-size: 36px;
            font-weight: bold;
            color: #343a40;
            margin-top: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .btn-custom {
            background-color: #4a90e2;
            color: #fff;
            border: none;
            padding: 15px 30px;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            border-radius: 50px;
            transition: background-color 0.3s ease;
            margin: 10px;
        }
        .btn-custom:hover { background-color: #357abd; }
        #admin-login-form { display: none; margin-top: 20px; }
        .logo-large { max-width: 400px; margin: 20px; }
    </style>
</head>
<body>

<div class="container-fluid text-center container-welcome">
    <!-- Ruta con slashes -->
    <img src="public/img/Logo Instiform.png" alt="Logo de Instiform" class="img-fluid logo-large">
    <h1 class="welcome-heading">Bienvenido a Instiform</h1>

    <!-- Apuntan a los PHP que están en app/controllers/ -->
    <button onclick="window.location.href='app/controllers/menuEstudiante.php'" class="btn btn-custom">
        Soy Estudiante
    </button>
    <button onclick="toggleAdminForm()" class="btn btn-custom">
        Soy Administrador
    </button>

    <div id="admin-login-form" class="col-md-4 offset-md-4">
        <form id="admin-form">
            <div class="form-group">
                <input type="password" id="admin-password" class="form-control"
                       placeholder="Contraseña del administrador" required>
            </div>
            <button type="submit" class="btn btn-custom btn-block">Ingresar</button>
        </form>
        <div id="login-error" style="color: red; margin-top: 10px;"></div>
    </div>
</div>

<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.5.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
function toggleAdminForm() {
    const f = document.getElementById('admin-login-form');
    f.style.display = (f.style.display === 'none' ? 'block' : 'none');
}

document.getElementById('admin-form').addEventListener('submit', e => {
    e.preventDefault();
    if (document.getElementById('admin-password').value === 'admin123') {
        location.href = 'app/controllers/menuAdministrador.php';
    } else {
        document.getElementById('login-error').innerText = 'Contraseña incorrecta.';
    }
});
<?php echo '</script'; ?>
>

</body>
</html>
<?php }
}
