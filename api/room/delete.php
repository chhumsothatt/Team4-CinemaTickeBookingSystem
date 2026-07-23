<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID!']);
        exit;
    }

    $sql = "DELETE FROM tbl_cinema_rooms WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([':id' => $id]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Room deleted successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete room.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>