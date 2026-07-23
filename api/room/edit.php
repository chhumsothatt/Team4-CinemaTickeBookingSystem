<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $id          = $_POST['id'] ?? '';
    $room_name   = $_POST['room_name'] ?? '';
    $total_seats = $_POST['total_seats'] ?? 0;

    if (empty($id) || empty($room_name) || empty($total_seats)) {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided!']);
        exit;
    }

    $sql = "UPDATE tbl_cinema_rooms SET room_name = :room_name, total_seats = :total_seats WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':room_name'   => $room_name,
        ':total_seats' => $total_seats,
        ':id'          => $id
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Room updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update room.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>