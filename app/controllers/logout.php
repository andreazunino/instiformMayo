<?php
require_once __DIR__ . '/../lib/auth.php';

logoutUser();
header('Location: ../../index.php?logged_out=1');
exit;
