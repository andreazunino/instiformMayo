<?php
require_once '../lib/smarty/libs/Smarty.class.php';

$smarty = new Smarty\Smarty;
$smarty->display('../templates/index.tpl');
