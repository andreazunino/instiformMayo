<?php
/* Smarty version 5.4.0, created on 2025-06-26 23:01:19
  from 'file:seleccionarEstudianteBoletin.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_685db51fde5bc9_22760716',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '89cd0e9d3c48d9beb1e4aa8a3812995ea4fccaa0' => 
    array (
      0 => 'seleccionarEstudianteBoletin.tpl',
      1 => 1749337190,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:footer.tpl' => 1,
  ),
))) {
function content_685db51fde5bc9_22760716 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
?><!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <?php $_smarty_tpl->renderSubTemplate('file:head.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>
    <style>
        .logo-small {
            max-width: 80px;
            margin-top: 10px;
        }
    </style>
</head>
<body>

<!-- Botón para volver al menú -->
<button class="btn btn-logout" onclick="window.location.href='menuAdministrador.php'">Volver al menú</button>

<!-- Encabezado -->
<div class="container text-center welcome-section">
    <img src="../../public/img/Logo Instiform.png" alt="Logo de Instiform" class="img-fluid logo-small">
    <h1 class="welcome-heading">Descargar Boletín de un Estudiante</h1>
</div>

<!-- Formulario -->
<div class="container text-center mt-4">
    <form action="generarBoletin.php" method="GET" target="_blank">
        <div class="form-group">
            <label for="dni">Seleccioná un estudiante:</label>
            <select name="dni" id="dni" class="form-control" required>
                <option value="">-- Seleccionar --</option>
                <?php
$_from = $_smarty_tpl->getSmarty()->getRuntime('Foreach')->init($_smarty_tpl, $_smarty_tpl->getValue('estudiantes'), 'e');
$foreach0DoElse = true;
foreach ($_from ?? [] as $_smarty_tpl->getVariable('e')->value) {
$foreach0DoElse = false;
?>
                    <option value="<?php echo $_smarty_tpl->getValue('e')['dni'];?>
"><?php echo $_smarty_tpl->getValue('e')['apellido'];?>
, <?php echo $_smarty_tpl->getValue('e')['nombre'];?>
 - DNI: <?php echo $_smarty_tpl->getValue('e')['dni'];?>
</option>
                <?php
}
$_smarty_tpl->getSmarty()->getRuntime('Foreach')->restore($_smarty_tpl, 1);?>
            </select>
        </div>
        <button type="submit" class="btn-custom">Descargar Boletín PDF</button>
    </form>
</div>

<!-- Footer -->
<?php $_smarty_tpl->renderSubTemplate('file:footer.tpl', $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), (int) 0, $_smarty_current_dir);
?>

</body>
</html>
<?php }
}
