<?php
/* Smarty version 5.4.0, created on 2025-12-02 20:23:21
  from 'file:administrarUsuarios.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_692f3ca9586d25_74715004',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'ceea86474a5e01296e5a84387e6e0c165328cbbc' => 
    array (
      0 => 'administrarUsuarios.tpl',
      1 => 1764703056,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_692f3ca9586d25_74715004 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php $_smarty_tpl->renderSubTemplate('file:head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
    <style>
        .panel-card {
            max-width: 820px;
            margin: 0 auto;
            text-align: left;
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.08);
            padding: 22px 26px;
        }
        .panel-table {
            max-width: 980px;
            margin: 0 auto;
        }
        .section-title {
            font-weight: 700;
            letter-spacing: 0.3px;
        }
        .input-group-label {
            font-weight: 600;
            color: #495057;
        }
    </style>
</head>
<body>

<button class="btn btn-logout" onclick="window.location.href='logout.php'">Cerrar sesión</button>

<div class="container-fluid text-center welcome-section">
    <img src="../../public/img/Logo Instiform.png" alt="Logo de Instiform" class="logo-small">
    <h1 class="welcome-heading">Instiform</h1>
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto d-flex">
            <li class="nav-item">
                <a class="nav-link" href="menuAdministrador.php">Volver al Menú Administrador</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-4">
    <?php if ($_smarty_tpl->getValue('mensaje')) {?>
        <div class="alert alert-<?php echo (($tmp = $_smarty_tpl->getValue('mensaje_tipo') ?? null)===null||$tmp==='' ? 'info' ?? null : $tmp);?>
" role="alert">
            <?php echo $_smarty_tpl->getValue('mensaje');?>

        </div>
    <?php }?>

    <h3 class="mb-3 text-center section-title">Administrar Usuarios</h3>

    <div class="panel-card mb-4">
        <form method="POST" action="">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" name="nombre" autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="apellido">Apellido</label>
                    <input type="text" class="form-control" id="apellido" name="apellido" autocomplete="off">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label class="input-group-label" for="dni">DNI</label>
                    <input type="text" class="form-control" id="dni" name="dni" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label class="input-group-label" for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" autocomplete="off">
                </div>
                <div class="form-group col-md-4">
                    <label class="input-group-label" for="role">Rol</label>
                    <select class="form-control" id="role" name="role" required>
                        <option value="">Seleccionar rol</option>
                        <option value="admin">Admin</option>
                        <option value="estudiante">Estudiante</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="username">Usuario</label>
                    <input type="text" class="form-control" id="username" name="username" required autocomplete="off">
                </div>
                <div class="form-group col-md-6">
                    <label class="input-group-label" for="password">Contraseña</label>
                    <input type="text" class="form-control" id="password" name="password" required autocomplete="off">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn-formal mt-2">Crear usuario</button>
            </div>
        </form>
    </div>

    <div class="panel-table">
        <h4 class="mb-3 text-center section-title">Usuarios existentes</h4>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Usuario</th>
                        <th>Rol</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>DNI</th>
                        <th>Email</th>
                        <th>Creado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('usuarios'), 'u');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('u')->value) {
$foreach0DoElse = false;
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->getValue('u')['username'];?>
</td>
                            <td><?php echo $_smarty_tpl->getValue('u')['role'];?>
</td>
                            <td><?php echo $_smarty_tpl->getValue('u')['nombre'];?>
</td>
                            <td><?php echo $_smarty_tpl->getValue('u')['apellido'];?>
</td>
                            <td><?php echo $_smarty_tpl->getValue('u')['dni'];?>
</td>
                            <td><?php echo $_smarty_tpl->getValue('u')['email'];?>
</td>
                            <td><?php echo $_smarty_tpl->getValue('u')['creado_en'];?>
</td>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                    <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('usuarios')) == 0) {?>
                        <tr>
                            <td colspan="7" class="text-center text-muted">No hay usuarios registrados.</td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<?php echo '<script'; ?>
 src="https://code.jquery.com/jquery-3.5.1.slim.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"><?php echo '</script'; ?>
>
<?php echo '<script'; ?>
 src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"><?php echo '</script'; ?>
>
</body>
</html>
<?php }
}
