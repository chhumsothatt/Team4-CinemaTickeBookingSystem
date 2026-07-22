<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$id = $data['id'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'Category ID is required']);
    exit;
}

try {
    $stmt = $pdo->prepare("DELETE FROM tbl_categories WHERE id = ?");
    $stmt->execute([$id]);

    echo json_encode(['status' => 'success', 'message' => 'Category deleted successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'Cannot delete: Category might be linked to existing movies.']);
}
?>