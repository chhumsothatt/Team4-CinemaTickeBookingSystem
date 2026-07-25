<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'សូមចូលប្រើប្រាស់គណនីជាមុនសិន!'
    ]);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $sql = "
        SELECT 
            b.id AS booking_id,
            b.booking_date,
            b.total_price,
            b.status,
            m.title AS movie_title,
            s.start_time,
            CONCAT(st.seat_row, st.seat_number) AS seat
        FROM tbl_bookings b
        JOIN tbl_showtimes s ON b.showtime_id = s.id
        JOIN tbl_movies m ON s.movie_id = m.id
        JOIN tbl_seats st ON b.seat_id = st.id
        WHERE b.user_id = :user_id
        ORDER BY b.id DESC
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':user_id' => $userId]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $history
    ]);

} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database Error: ' . $e->getMessage()
    ]);
}