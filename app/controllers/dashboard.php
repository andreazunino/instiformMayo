<?php
require_once __DIR__ . '/../../sql/db.php';
require_once __DIR__ . '/../services/MetricsService.php';
require_once __DIR__ . '/../lib/auth.php';

requireLogin(['admin']);

$service = new MetricsService($pdo);
$data = $service->obtenerBasicas();

header('Content-Type: application/json');
echo json_encode($data);
exit;
