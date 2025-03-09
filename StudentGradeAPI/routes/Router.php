<?php
require_once __DIR__ . '/../controllers/StudentController.php';

header("Content-Type: application/json");
$method = $_SERVER['REQUEST_METHOD'];
$data = json_decode(file_get_contents("php://input"), true) ?? $_GET;

$controller = new StudentController();
$controller->handleRequest($method, $data);
