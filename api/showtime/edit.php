<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id           = intval($_POST['id'] ?? 0);
    $movie_id     = intval($_POST['movie_id'] ?? 0);
    $room_id      = intval($_POST['room_id'] ?? 0);
    $show_date    = $_POST['show_date'] ?? '';
    $start_time   = $_POST['start_time'] ?? '';
    $end_time     = $_POST['end_time'] ?? '';
    $ticket_price = floatval($_POST['price'] ?? 0);

    $full_start_time = $show_date . ' ' . $start_time . ':00';
    $full_end_time   = $show_date . ' ' . $end_time . ':00';

    if ($id > 0 && $movie_id > 0 && $room_id > 0 && !empty($show_date) && !empty($start_time) && !empty($end_time) && $ticket_price > 0) {
        try {
            $stmt = $pdo->prepare("UPDATE tbl_showtimes 
                                   SET movie_id = :movie_id, 
                                       room_id = :room_id, 
                                       start_time = :start_time, 
                                       end_time = :end_time, 
                                       ticket_price = :ticket_price 
                                   WHERE id = :id");
            $stmt->execute([
                ':movie_id'     => $movie_id,
                ':room_id'      => $room_id,
                ':start_time'   => $full_start_time,
                ':end_time'     => $full_end_time,
                ':ticket_price' => $ticket_price,
                ':id'           => $id
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Showtime updated successfully!'
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
            'message' => 'Please fill in all required fields.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method.'
    ]);
}
?>