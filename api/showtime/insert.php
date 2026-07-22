<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $movie_id     = intval($_POST['movie_id'] ?? 0);
    $room_id      = intval($_POST['room_id'] ?? 0);
    $show_date    = $_POST['show_date'] ?? '';
    $start_time   = $_POST['start_time'] ?? '';
    $end_time     = $_POST['end_time'] ?? '';
    $ticket_price = floatval($_POST['price'] ?? 0);

    // បូកបញ្ចូល Date + Time ឱ្យត្រូវតាម DATETIME format (YYYY-MM-DD HH:MM:SS)
    $full_start_time = $show_date . ' ' . $start_time . ':00';
    $full_end_time   = $show_date . ' ' . $end_time . ':00';

    if ($movie_id > 0 && $room_id > 0 && !empty($show_date) && !empty($start_time) && !empty($end_time) && $ticket_price > 0) {
        try {
            $stmt = $pdo->prepare("INSERT INTO tbl_showtimes (movie_id, room_id, start_time, end_time, ticket_price) 
                                   VALUES (:movie_id, :room_id, :start_time, :end_time, :ticket_price)");
            $stmt->execute([
                ':movie_id'     => $movie_id,
                ':room_id'      => $room_id,
                ':start_time'   => $full_start_time,
                ':end_time'     => $full_end_time,
                ':ticket_price' => $ticket_price
            ]);

            echo json_encode([
                'success' => true,
                'message' => 'Showtime created successfully!'
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
