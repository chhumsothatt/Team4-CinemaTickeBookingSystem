<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $room_name   = $_POST['room_name'] ?? '';
    $total_seats = $_POST['total_seats'] ?? 0;

    if (empty($room_name) || empty($total_seats)) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all fields!']);
        exit;
    }

    $sql = "INSERT INTO tbl_cinema_rooms (room_name, total_seats) VALUES (:room_name, :total_seats)";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        ':room_name'   => $room_name,
        ':total_seats' => $total_seats
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Room added successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add room.']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>