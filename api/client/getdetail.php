<?php 
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    if (!isset($_GET['movie_id']) || empty($_GET['movie_id'])) {
        echo json_encode(['success' => false, 'message' => 'Movie ID is required.']);
        exit;
    }

    $movieId = intval($_GET['movie_id']);

    // 1. Fetch movie details
    $stmt = $pdo->prepare("
        SELECT 
            m.id, m.title, m.description, m.poster, 
            m.duration_minutes, m.release_date,
            c.name AS category_name
        FROM tbl_movies m
        LEFT JOIN tbl_categories c ON m.category_id = c.id
        WHERE m.id = ?
    ");
    $stmt->execute([$movieId]);
    $movie = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movie) {
        echo json_encode(['success' => false, 'message' => 'Movie not found.']);
        exit;
    }

    // 2. Fetch showtimes with room details
    $stmtShowtimes = $pdo->prepare("
        SELECT 
            s.id, s.room_id, s.start_time, s.end_time, s.ticket_price,
            r.room_name 
        FROM tbl_showtimes s
        JOIN tbl_cinema_rooms r ON s.room_id = r.id
        WHERE s.movie_id = ? AND s.start_time >= NOW()
        ORDER BY s.start_time ASC
    ");
    $stmtShowtimes->execute([$movieId]);
    $showtimes = $stmtShowtimes->fetchAll(PDO::FETCH_ASSOC);

    // 3. Fetch seats and booked seat IDs per showtime
    $showtimeIds = array_column($showtimes, 'id');
    $bookedSeats = [];
    if (!empty($showtimeIds)) {
        $in  = str_repeat('?,', count($showtimeIds) - 1) . '?';
        $stmtBooked = $pdo->prepare("SELECT showtime_id, seat_id FROM tbl_bookings WHERE showtime_id IN ($in) AND status != 'cancelled'");
        $stmtBooked->execute($showtimeIds);
        while ($row = $stmtBooked->fetch(PDO::FETCH_ASSOC)) {
            $bookedSeats[$row['showtime_id']][] = $row['seat_id'];
        }
    }

    // Fetch seats per room
    $roomIds = array_unique(array_column($showtimes, 'room_id'));
    $seatsByRoom = [];
    if (!empty($roomIds)) {
        $in  = str_repeat('?,', count($roomIds) - 1) . '?';
        $stmtSeats = $pdo->prepare("SELECT id, room_id, seat_row, seat_number FROM tbl_seats WHERE room_id IN ($in) ORDER BY seat_row ASC, seat_number ASC");
        $stmtSeats->execute($roomIds);
        while ($row = $stmtSeats->fetch(PDO::FETCH_ASSOC)) {
            $seatsByRoom[$row['room_id']][] = $row;
        }
    }

    echo json_encode([
        'success'    => true,
        'movie'      => $movie,
        'showtimes'  => $showtimes,
        'seatsByRoom'=> $seatsByRoom,
        'bookedSeats'=> $bookedSeats
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}