<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json');


if (file_exists('../../config/database.php')) {
    require_once '../../config/database.php';
} elseif (file_exists('../config/database.php')) {
    require_once '../config/database.php';
} else {
    echo json_encode(['success' => false, 'message' => 'Cannot find database.php file!']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 2. Validation ពិនិត្យ Data ពី Form
    if (empty($_POST['movie_id']) || empty($_POST['room_id']) || empty($_POST['show_date']) || empty($_POST['start_time']) || !isset($_POST['price'])) {
        echo json_encode(['success' => false, 'message' => 'Please fill in all required fields accurately.']);
        exit;
    }

    $movie_id   = $_POST['movie_id'];
    $room_id    = $_POST['room_id'];
    $show_date  = $_POST['show_date'];   
    $start_time = $_POST['start_time'];  
    $price      = $_POST['price'];

    try {
        // 3. ទាញយក duration_minutes ពី tbl_movies
        $stmtMovie = $pdo->prepare("SELECT duration_minutes FROM tbl_movies WHERE id = ?");
        $stmtMovie->execute([$movie_id]);
        $movie = $stmtMovie->fetch();

        if (!$movie) {
            echo json_encode(['success' => false, 'message' => 'Movie not found in database!']);
            exit;
        }

        $duration_minutes = !empty($movie['duration_minutes']) ? (int)$movie['duration_minutes'] : 120;

        // 4. បញ្ចូល Show Date និង Start Time ចូលគ្នាដើម្បីបង្កើតទម្រង់ DATETIME (YYYY-MM-DD HH:MM:SS)
        $fullStartDateTime = new DateTime("$show_date $start_time");
        $start_datetime = $fullStartDateTime->format('Y-m-d H:i:s');

        // 5. គណនា end_time (DATETIME) ដោយបូកបន្ថែម duration_minutes
        $fullStartDateTime->modify("+$duration_minutes minutes");
        $end_datetime = $fullStartDateTime->format('Y-m-d H:i:s');

        // 6. Insert ចូល tbl_showtimes (ប្រើ start_time, end_time, ticket_price)
        $sql = "INSERT INTO tbl_showtimes (movie_id, room_id, start_time, end_time, ticket_price) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$movie_id, $room_id, $start_datetime, $end_datetime, $price]);

        if ($result) {
            echo json_encode(['success' => true, 'message' => 'Showtime created successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to insert showtime record.']);
        }

    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database Error: ' . $e->getMessage()]);
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Invalid Request Method.']);
}
?>