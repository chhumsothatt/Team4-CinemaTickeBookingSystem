<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);

$id   = $data['id'] ?? null;
$name = trim($data['name'] ?? '');

if (!$id || empty($name)) {
    echo json_encode(['status' => 'error', 'message' => 'Category ID and Name are required.']);
    exit;
}

try {
    $stmt = $pdo->prepare("UPDATE tbl_categories SET name = ? WHERE id = ?");
    $stmt->execute([$name, $id]);

    echo json_encode(['status' => 'success', 'message' => 'Category updated successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>