<?php
/* Smarty version 5.4.0, created on 2025-06-26 23:01:06
  from 'file:index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_685db512144157_50561672',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a1736d6204912ee81c4ec9d3b9f31d5f683d272' => 
    array (
      0 => 'index.tpl',
      1 => 1748461927,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_685db512144157_50561672 (\Smarty\Template $_smarty_tpl) {
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
        .btn-custom:hover {
            background-color: #357abd;
        }
        .logo-large {
            max-width: 400px;
            margin: 20px;
        }
    </style>
</head>
<body>

<div class="container-fluid text-center container-welcome">
    <img src="public/img/Logo Instiform.png" alt="Logo de Instiform" class="img-fluid logo-large">
    <h1 class="welcome-heading">Bienvenido a Instiform</h1>

    <button onclick="window.location.href='app/controllers/menuEstudiante.php'" class="btn btn-custom">
        Soy Estudiante
    </button>

    <button class="btn btn-custom" data-toggle="modal" data-target="#adminModal">
        Soy Administrador
    </button>
</div>

<!-- Modal para administrador -->
<div class="modal fade" id="adminModal" tabindex="-1" role="dialog" aria-labelledby="adminModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="admin-form">
        <div class="modal-header">
          <h5 class="modal-title" id="adminModalLabel">Contraseña del administrador</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <input type="password" class="form-control" id="admin-password" placeholder="Ingrese contraseña" required>
          <div id="login-error" class="text-danger mt-2"></div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-custom">Ingresar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Scripts -->
<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.5.1.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
>
document.getElementById('admin-form').addEventListener('submit', function (e) {
    e.preventDefault();
    const password = document.getElementById('admin-password').value;
    if (password === 'admin123') {
        window.location.href = 'app/controllers/menuAdministrador.php';
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
