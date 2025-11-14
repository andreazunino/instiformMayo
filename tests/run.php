<?php

declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

$runner = new TestRunner();
$runner->addTest(new EstudianteModelTest());
$runner->addTest(new CursoModelTest());

$success = $runner->run();
exit($success ? 0 : 1);
