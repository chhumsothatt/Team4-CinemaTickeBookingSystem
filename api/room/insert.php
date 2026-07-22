<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_name   = trim($_POST['room_name'] ?? '');
    $total_seats = intval($_POST['total_seats'] ?? 0);

    if (!empty($room_name) && $total_seats > 0) {
        try {
            // កែសម្រួលមកប្រើ tbl_cinema_rooms
            $stmt = $pdo->prepare("INSERT INTO tbl_cinema_rooms (room_name, total_seats) VALUES (:room_name, :total_seats)");
            $stmt->execute([
                ':room_name'   => $room_name,
                ':total_seats' => $total_seats
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Cinema room created successfully!'
            ]);
        } catch (PDOException $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Please fill in all required fields properly.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>
