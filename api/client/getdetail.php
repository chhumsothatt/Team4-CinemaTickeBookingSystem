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
            COALESCE(c.name, 'General') AS category_name
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

    // 2. Fetch showtimes with pre-formatted Date & Time
    $stmtShowtimes = $pdo->prepare("
        SELECT 
            s.id, 
            s.movie_id, 
            s.room_id, 
            s.start_time, 
            s.end_time, 
            s.ticket_price,
            COALESCE(r.room_name, 'Standard Room') AS room_name,
            DATE_FORMAT(s.start_time, '%h:%i %p') AS formatted_time,
            DATE_FORMAT(s.start_time, '%d %b %Y') AS formatted_date
        FROM tbl_showtimes s
        LEFT JOIN tbl_cinema_rooms r ON s.room_id = r.id
        WHERE s.movie_id = ?
        ORDER BY s.start_time ASC
    ");
    $stmtShowtimes->execute([$movieId]);
    $showtimes = $stmtShowtimes->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success'   => true,
        'movie'     => $movie,
        'showtimes' => $showtimes
    ]);

} catch (Throwable $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
}
?>