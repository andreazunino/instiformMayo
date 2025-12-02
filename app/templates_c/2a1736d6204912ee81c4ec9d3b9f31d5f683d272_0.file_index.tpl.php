<?php
/* Smarty version 5.4.0, created on 2025-12-02 16:14:23
  from 'file:index.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_692f024f6935e4_28044128',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '2a1736d6204912ee81c4ec9d3b9f31d5f683d272' => 
    array (
      0 => 'index.tpl',
      1 => 1764687391,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_692f024f6935e4_28044128 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Instiform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="public/css/styles.css">
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
        .logo-large {
            max-width: 400px;
            margin: 20px;
        }
        .login-card {
            max-width: 420px;
            width: 100%;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
            padding: 28px 32px;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-primary {
            border-radius: 10px;
        }
        .hero-stack {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 14px;
            width: 100%;
        }
        .login-trigger {
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            width: 220px;
        }
        .modal-dialog-centered {
            display: flex;
            align-items: center;
            min-height: calc(100vh - 1rem);
        }
        .modal-dialog {
            margin: 0 auto;
        }
    </style>
</head>
<body>

<div class="container-fluid d-flex flex-column align-items-center justify-content-center container-welcome">
    <div class="hero-stack">
        <img src="public/img/Logo Instiform.png" alt="Logo de Instiform" class="img-fluid logo-large">
        <h1 class="welcome-heading">Bienvenido a Instiform</h1>
        <p class="text-muted">Tu portal para estudiantes y administradores.</p>
        <?php if ($_smarty_tpl->getValue('loginError')) {?>
            <div class="alert alert-info mt-2 mb-1 text-center status-alert" role="alert"><?php echo $_smarty_tpl->getValue('loginError');?>
</div>
        <?php }?>
        <button class="btn btn-primary login-trigger" data-toggle="modal" data-target="#loginModal">
            Ingresar
        </button>
    </div>
</div>

<!-- Modal de ingreso -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content login-card">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Ingresar</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form method="POST" action="index.php" novalidate>
            <div class="form-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" class="form-control" required autocomplete="username">
            </div>
            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" class="form-control" required autocomplete="current-password">
            </div>
            <small class="d-block mb-2 text-muted">Usa tu cuenta de administrador o estudiante.</small>
            <button type="submit" class="btn btn-primary btn-block mt-2">Ingresar</button>
        </form>
      </div>
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

</body>
</html>
<?php }
}
