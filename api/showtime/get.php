<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$id = isset($_GET['id']) ? trim($_GET['id']) : '';

try {
    if (!empty($id)) {
        // ទាញយក Showtime តែមួយតាម ID
        $sql = "SELECT * FROM tbl_showtimes WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            // បំបែក DATETIME (2026-08-01 10:00:00) ទៅជា Date និង Time
            $start = new DateTime($row['start_time']);
            $end   = new DateTime($row['end_time']);

            $showtime = [
                'id'          => $row['id'],
                'movie_id'    => $row['movie_id'],
                'room_id'     => $row['room_id'],
                'show_date'   => $start->format('Y-m-d'), // ទាញយកតែ 2026-08-01
                'start_time'  => $start->format('H:i'),   // ទាញយកតែ 10:00
                'end_time'    => $end->format('H:i'),     // ទាញយកតែ 13:00
                'price'       => $row['ticket_price']     // 💡 កែពី ticket_price មក price
            ];

            echo json_encode(['status' => 'success', 'data' => $showtime]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Showtime not found']);
        }
    } else {
        // ទាញយកទាំងអស់សម្រាប់បង្ហាញលើ Table
        $sql = "SELECT s.*, m.title AS movie_title, r.room_name 
                FROM tbl_showtimes s
                LEFT JOIN tbl_movies m ON s.movie_id = m.id
                LEFT JOIN tbl_cinema_rooms r ON s.room_id = r.id
                ORDER BY s.id DESC";
        $stmt = $pdo->query($sql);
        $showtimes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // បន្ថែម formatted time សម្រាប់ Table
        foreach ($showtimes as &$item) {
            $start = new DateTime($item['start_time']);
            $end   = new DateTime($item['end_time']);
            $item['formatted_date'] = $start->format('d-M-Y');
            $item['formatted_time'] = $start->format('h:i A') . ' - ' . $end->format('h:i A');
            $item['price']          = $item['ticket_price'];
        }

        echo json_encode(['status' => 'success', 'data' => $showtimes]);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>