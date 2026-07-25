<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    // 💡 JOIN ដោយប្រើ u.name ត្រូវតាម DB របស់បង ១០០%
    $sql = "SELECT 
                b.id AS booking_id,
                u.name AS user_name,
                m.title AS movie_title,
                DATE_FORMAT(s.start_time, '%d/%m - %h:%i %p') AS showtime_formatted,
                st.seat_number,
                b.status
            FROM tbl_bookings b
            LEFT JOIN tbl_users u ON b.user_id = u.id
            LEFT JOIN tbl_showtimes s ON b.showtime_id = s.id
            LEFT JOIN tbl_movies m ON s.movie_id = m.id
            LEFT JOIN tbl_seats st ON b.seat_id = st.id
            ORDER BY b.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $bookings = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => $bookings
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database Error: ' . $e->getMessage()
    ]);
}
?>