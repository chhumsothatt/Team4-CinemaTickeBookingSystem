<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $room_name     = trim($_POST['room_name'] ?? '');
    $total_seats   = (int)($_POST['total_seats'] ?? 0);
    $seats_per_row = (int)($_POST['seats_per_row'] ?? 10); // កំណត់ ១០ កៅអីក្នុង ១ ជួរ (A1-A10, B1-B10...)

    if (empty($room_name) || $total_seats <= 0) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all valid fields!']);
        exit;
    }

    // ចាប់ផ្តើម Transaction
    $pdo->beginTransaction();

    // ១. បញ្ចូលទិន្នន័យបន្ទប់ទៅក្នុង tbl_cinema_rooms
    $sqlRoom = "INSERT INTO tbl_cinema_rooms (room_name, total_seats, created_at) VALUES (:room_name, :total_seats, NOW())";
    $stmtRoom = $pdo->prepare($sqlRoom);
    $stmtRoom->execute([
        ':room_name'   => $room_name,
        ':total_seats' => $total_seats
    ]);

    // យក ID នៃបន្ទប់ដែលទើបតែបង្កើតរួច
    $roomId = $pdo->lastInsertId();

    // ២. រៀបចំ Query សម្រាប់បញ្ចូលកៅអីទៅក្នុង tbl_seats
    $sqlSeat = "INSERT INTO tbl_seats (room_id, seat_row, seat_number, created_at) VALUES (:room_id, :seat_row, :seat_number, NOW())";
    $stmtSeat = $pdo->prepare($sqlSeat);

    for ($i = 0; $i < $total_seats; $i++) {
        // គណនាអក្សរជួរ (0 = A, 1 = B, 2 = C...)
        $rowLetter = chr(65 + (int)floor($i / $seats_per_row));
        
        // គណនាលេខកៅអីតាមជួរ (1, 2, 3... 10)
        $seatNumber = ($i % $seats_per_row) + 1;

        $stmtSeat->execute([
            ':room_id'     => $roomId,
            ':seat_row'    => $rowLetter,
            ':seat_number' => $seatNumber
        ]);
    }

    // បញ្ចប់ Transaction ដោយជោគជ័យ
    $pdo->commit();

    echo json_encode([
        'success' => true, 
        'message' => "Room and $total_seats seats added successfully!"
    ]);

} catch (PDOException $e) {
    // ប្រសិនបើមាន Error នឹង Cancel រាល់ Action ទាំងអស់ក្នុង Database (Rollback)
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
?>