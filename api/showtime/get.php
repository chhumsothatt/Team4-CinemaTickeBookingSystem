<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $sql = "SELECT 
                s.id,
                COALESCE(m.title, 'N/A') AS movie_title,
                COALESCE(r.room_name, 'N/A') AS room_name,
                DATE_FORMAT(s.start_time, '%d/%m/%Y') AS formatted_date,
                DATE_FORMAT(s.start_time, '%h:%i %p') AS formatted_time
            FROM tbl_showtimes s
            LEFT JOIN tbl_movies m ON s.movie_id = m.id
            LEFT JOIN tbl_cinema_rooms r ON s.room_id = r.id
            ORDER BY s.id DESC";

    $stmt = $pdo->query($sql);
    $showtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data'    => $showtimes
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage()
    ]);
}
?>

