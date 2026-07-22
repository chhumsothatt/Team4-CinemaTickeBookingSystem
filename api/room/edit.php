//edit
<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ទទួលទិន្នន័យពី Form ឬ AJAX
    $id          = intval($_POST['id'] ?? 0);
    $room_name   = trim($_POST['room_name'] ?? '');
    $total_seats = intval($_POST['total_seats'] ?? 0);

    // ត្រួតពិនិត្យថាមានទិន្នន័យត្រឹមត្រូវឬទេ
    if ($id > 0 && !empty($room_name) && $total_seats > 0) {
        try {
            // សរសេរ Query UPDATE ជាមួយ PDO Prepared Statement
            $stmt = $pdo->prepare("UPDATE rooms SET room_name = :room_name, total_seats = :total_seats WHERE id = :id");
            
            $stmt->execute([
                ':room_name'   => $room_name,
                ':total_seats' => $total_seats,
                ':id'          => $id
            ]);

            echo json_encode([
                'success' => true, 
                'message' => 'Room updated successfully!'
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
            'message' => 'Please provide valid data for all fields.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid request method.'
    ]);
}
?>
