<?php
session_start();
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

// Handle GET: Fetch Showtime Info & Seat Map
if ($method === 'GET') {
    try {
        if (!isset($_GET['showtime_id']) || empty($_GET['showtime_id'])) {
            echo json_encode(['success' => false, 'message' => 'Showtime ID is required.']);
            exit;
        }

        $showtimeId = intval($_GET['showtime_id']);

        // Fetch Showtime Details
        $stmt = $pdo->prepare("
            SELECT 
                s.id AS showtime_id, s.ticket_price,
                s.start_time, DATE_FORMAT(s.start_time, '%d %b %Y') AS formatted_date,
                DATE_FORMAT(s.start_time, '%h:%i %p') AS formatted_time,
                m.title AS movie_title, m.poster,
                r.id AS room_id, COALESCE(r.room_name, 'Standard Room') AS room_name
            FROM tbl_showtimes s
            INNER JOIN tbl_movies m ON s.movie_id = m.id
            LEFT JOIN tbl_cinema_rooms r ON s.room_id = r.id
            WHERE s.id = ?
        ");
        $stmt->execute([$showtimeId]);
        $showtime = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$showtime) {
            echo json_encode(['success' => false, 'message' => 'Showtime not found.']);
            exit;
        }

        // Fetch All Seats for this room
        $stmtSeats = $pdo->prepare("
            SELECT id, seat_row, seat_number 
            FROM tbl_seats 
            WHERE room_id = ?
            ORDER BY seat_row ASC, seat_number ASC
        ");
        $stmtSeats->execute([$showtime['room_id']]);
        $seats = $stmtSeats->fetchAll(PDO::FETCH_ASSOC);

        // Fetch Already Booked Seat IDs for this showtime
        $stmtBooked = $pdo->prepare("
            SELECT seat_id 
            FROM tbl_bookings 
            WHERE showtime_id = ? AND status IN ('paid', 'pending')
        ");
        $stmtBooked->execute([$showtimeId]);
        $bookedSeatIds = $stmtBooked->fetchAll(PDO::FETCH_COLUMN);

        echo json_encode([
            'success' => true,
            'showtime' => $showtime,
            'seats' => $seats,
            'booked_seat_ids' => $bookedSeatIds
        ]);
    } catch (Throwable $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
    }
    exit;
}

// Handle POST: Submit Booking
if ($method === 'POST') {
    try {
$data = json_decode(file_get_contents('php://input'), true) ?? $_POST;
        $userId = $_SESSION['user_id'] ?? 1; // Fallback to 1 if session user isn't set
        $showtimeId = intval($data['showtime_id'] ?? 0);
        $seatIds = $data['seat_ids'] ?? [];

        if (!$showtimeId || empty($seatIds)) {
            echo json_encode(['success' => false, 'message' => 'Invalid booking data provided.']);
            exit;
        }

        // Get single ticket price
        $stmtPrice = $pdo->prepare("SELECT ticket_price FROM tbl_showtimes WHERE id = ?");
        $stmtPrice->execute([$showtimeId]);
        $ticketPrice = $stmtPrice->fetchColumn();

        if ($ticketPrice === false) {
            echo json_encode(['success' => false, 'message' => 'Showtime not found.']);
            exit;
        }

        $pdo->beginTransaction();

        // Check availability & insert each seat booking
        $stmtCheck = $pdo->prepare("
            SELECT COUNT(*) FROM tbl_bookings 
            WHERE showtime_id = ? AND seat_id = ? AND status IN ('paid', 'pending')
        ");

        $stmtInsert = $pdo->prepare("
            INSERT INTO tbl_bookings (user_id, showtime_id, seat_id, total_price, status) 
            VALUES (?, ?, ?, ?, 'paid')
        ");

        foreach ($seatIds as $seatId) {
            $seatId = intval($seatId);

            // Double check seat availability
            $stmtCheck->execute([$showtimeId, $seatId]);
            if ($stmtCheck->fetchColumn() > 0) {
                $pdo->rollBack();
                echo json_encode(['success' => false, 'message' => "Seat ID $seatId is already booked."]);
                exit;
            }

            $stmtInsert->execute([$userId, $showtimeId, $seatId, $ticketPrice]);
        }

        $pdo->commit();

        echo json_encode(['success' => true, 'message' => 'Booking saved successfully!']);

    } catch (Throwable $e) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Booking Failed: ' . $e->getMessage()]);
    }
    exit;
}