<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    $id = intval($_GET['id'] ?? 0);

    if ($id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid ID']);
        exit;
    }

    $sql = "SELECT 
                id,
                movie_id,
                room_id,
                ticket_price AS price,
                DATE(start_time) AS show_date,
                TIME_FORMAT(TIME(start_time), '%H:%i') AS start_time,
                TIME_FORMAT(TIME(end_time), '%H:%i') AS end_time
            FROM tbl_showtimes 
            WHERE id = :id";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $id]);
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode(['success' => true, 'data' => $data]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Showtime not found']);
    }

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>