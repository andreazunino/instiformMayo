<?php

declare(strict_types=1);

error_reporting(E_ALL);
ini_set('display_errors', '1');

const BASE_PATH = __DIR__ . '/..';

require_once BASE_PATH . '/app/models/Estudiante.php';
require_once BASE_PATH . '/app/models/Curso.php';
require_once __DIR__ . '/support/TestCase.php';
require_once __DIR__ . '/support/TestRunner.php';
require_once __DIR__ . '/unit/EstudianteModelTest.php';
require_once __DIR__ . '/unit/CursoModelTest.php';
