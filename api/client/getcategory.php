<?php 
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, name FROM tbl_categories ORDER BY name ASC");
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true, 
        'data' => $data
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false, 
        'message' => 'Database Error: ' . $e->getMessage()
    ]);
}
?>