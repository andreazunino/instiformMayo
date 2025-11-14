<?php
/* Smarty version 5.4.0, created on 2025-11-14 15:16:00
  from 'file:boletin.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_691739a06ba818_13078533',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'bd44bf459e10bf4f4968cbe4a58735a7916d0478' => 
    array (
      0 => 'boletin.tpl',
      1 => 1763129723,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_691739a06ba818_13078533 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Boletín - Instiform</title>
    <?php $_smarty_tpl->renderSubTemplate('file:head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
    <style>
        .logo-small {
            max-width: 80px;
            margin-top: 10px;
        }
        .tabla-calificaciones {
            margin: 0 auto;
        }
        .tabla-calificaciones th:nth-child(2),
        .tabla-calificaciones td:nth-child(2) {
            text-align: center;
        }
        .lista-calificaciones {
            margin: 0;
            padding-left: 0;
            text-align: center;
            list-style-position: inside;
        }
        .lista-calificaciones li {
            list-style-type: disc;
        }
    </style>
</head>
<body>

<!-- Botón de cerrar sesión -->
<button class="btn btn-logout" onclick="window.location.href='../../index.php'">Cerrar sesión</button>

<!-- Encabezado con logo -->
<div class="container-fluid text-center welcome-section">
    <img src="../../public/img/Logo Instiform.png" alt="Logo de Instiform" class="logo-small">
    <h1 class="welcome-heading">Instiform</h1>
</div>

<!-- Menú de navegación -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mx-auto d-flex">
            <li class="nav-item">
                <a class="nav-link" href="menuEstudiante.php">Volver al Menú Estudiante</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Contenido principal -->
<div class="container text-center">
    <!-- Formulario para buscar boletín -->
    <h3>Consultar Boletín</h3>
    <form method="POST" action="">
        <input type="hidden" name="accion" value="buscar">
        <div class="form-group">
            <label for="dni">DNI del Estudiante:</label>
            <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese el DNI del estudiante" required pattern="\d+" autocomplete="off">
        </div>
        <button type="submit" class="btn-formal">Buscar</button>
    </form>

    <!-- Mostrar mensaje -->
    <?php if ((null !== ($_smarty_tpl->getValue('mensaje') ?? null))) {?>
        <div class="alert alert-<?php echo (($tmp = $_smarty_tpl->getValue('mensaje_tipo') ?? null)===null||$tmp==='' ? 'info' ?? null : $tmp);?>
 mt-3"><?php echo $_smarty_tpl->getValue('mensaje');?>
</div>
    <?php }?>

    <!-- Mostrar tabla de notas -->
    <?php if ((null !== ($_smarty_tpl->getValue('notas') ?? null))) {?>
        <?php if ($_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('notas')) > 0) {?>
            <h3 class="mt-4">Calificaciones</h3>
            <table class="table table-striped mt-3 tabla-calificaciones">
                <thead>
                    <tr>
                        <th>Materia</th>
                        <th>Calificaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('notas'), 'nota');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('nota')->value) {
$foreach0DoElse = false;
?>
                        <tr>
                            <td><?php echo $_smarty_tpl->getValue('nota')['materia'];?>
</td>
                            <td>
                                <?php if ((null !== ($_smarty_tpl->getValue('nota')['calificaciones'] ?? null)) && $_smarty_tpl->getSmarty()->getModifierCallback('count')($_smarty_tpl->getValue('nota')['calificaciones']) > 0) {?>
                                    <ul class="lista-calificaciones">
                                        <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('nota')['calificaciones'], 'detalle');
$foreach1DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('detalle')->value) {
$foreach1DoElse = false;
?>
                                            <li>
                                                <?php echo $_smarty_tpl->getValue('detalle')['valor'];?>

                                                <?php if ($_smarty_tpl->getValue('detalle')['fecha_formateada']) {?>
                                                    <span class="text-muted">(<?php echo $_smarty_tpl->getValue('detalle')['fecha_formateada'];?>
)</span>
                                                <?php }?>
                                            </li>
                                        <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                                    </ul>
                                <?php } else { ?>
                                    <?php echo (($tmp = $_smarty_tpl->getValue('nota')['calificacion'] ?? null)===null||$tmp==='' ? '-' ?? null : $tmp);?>

                                <?php }?>
                            </td>
                        </tr>
                    <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
                </tbody>
            </table>
        <?php } else { ?>
            <p class="mt-3">No se encontraron calificaciones para el DNI ingresado.</p>
        <?php }?>
    <?php }?>
</div>

<!-- Footer -->
<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

<!-- Scripts necesarios -->
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
