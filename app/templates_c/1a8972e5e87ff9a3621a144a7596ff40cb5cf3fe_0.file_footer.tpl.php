<?php
/* Smarty version 5.4.0, created on 2025-06-26 23:01:16
  from 'file:footer.tpl' */

/* @var \Smarty\Template $_smarty_tpl */
if ($_smarty_tpl->getCompiled()->isFresh($_smarty_tpl, array (
  'version' => '5.4.0',
  'unifunc' => 'content_685db51c22e5d5_30672982',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '1a8972e5e87ff9a3621a144a7596ff40cb5cf3fe' => 
    array (
      0 => 'footer.tpl',
      1 => 1749335270,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
  ),
))) {
function content_685db51c22e5d5_30672982 (\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
$_smarty_tpl->getInheritance()->init($_smarty_tpl, false);
?>
<body class="d-flex flex-column min-vh-100">
    <main class="flex-fill">
        <?php 
$_smarty_tpl->getInheritance()->instanceBlock($_smarty_tpl, 'Block_465711650685db51c1d3319_21356034', 'content');
?>

    </main>

    <footer class="bg-light text-center text-lg-start py-3 border-top mt-auto">
        <div class="container text-center">
            <span class="text-muted">&copy; 2025 Instiform. Todos los derechos reservados.</span>
        </div>
    </footer>
</body>
<?php }
/* {block 'content'} */
class Block_465711650685db51c1d3319_21356034 extends \Smarty\Runtime\Block
{
public function callBlock(\Smarty\Template $_smarty_tpl) {
$_smarty_current_dir = 'C:\\xampp\\htdocs\\InstiformMayo\\app\\views';
}
}
/* {/block 'content'} */
}
