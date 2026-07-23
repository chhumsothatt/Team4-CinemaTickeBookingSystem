<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$name = trim($data['name'] ?? '');

if (empty($name)) {
    echo json_encode(['status' => 'error', 'message' => 'Category name is required']);
    exit;
}
try {
    $stmt = $pdo->prepare("INSERT INTO tbl_categories (name) VALUES (?)");
    $stmt->execute([$name]);

    echo json_encode(['status' => 'success', 'message' => 'Category created successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
