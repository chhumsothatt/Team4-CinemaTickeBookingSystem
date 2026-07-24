<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    // JOIN ទាញយករូប Poster ពី tbl_movies និងឈ្មោះបន្ទប់ពី tbl_cinema_rooms
    $sql = "SELECT 
                s.id,
                m.title AS movie_title,
                m.poster AS movie_poster,
                r.room_name,
                DATE_FORMAT(s.start_time, '%d-%b-%Y') AS show_date,
                DATE_FORMAT(s.start_time, '%h:%i %p') AS start_time_formatted,
                DATE_FORMAT(s.end_time, '%h:%i %p') AS end_time_formatted
            FROM tbl_showtimes s
            LEFT JOIN tbl_movies m ON s.movie_id = m.id
            LEFT JOIN tbl_cinema_rooms r ON s.room_id = r.id
            ORDER BY s.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $showtimes = $stmt->fetchAll();

    echo json_encode([
        'success' => true,
        'data' => $showtimes
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Database Error: ' . $e->getMessage()
    ]);
}
?>