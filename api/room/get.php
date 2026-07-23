<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $sql = "SELECT * FROM tbl_cinema_rooms ORDER BY id DESC";
    $stmt = $pdo->query($sql);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data'    => $rooms
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>