<?php
session_start();
header('Content-Type: application/json');
require_once '../../config/database.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

try {
    $userId = $_SESSION['user_id'];
    
    // Fetch current user details
    $stmt = $pdo->prepare("SELECT id, name, email, role FROM tbl_users WHERE id = :id LIMIT 1");
    $stmt->execute([':id' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $name = trim($user['name']);
        $words = explode(' ', $name);
        $initials = '';

        // Generate 2 initials (e.g. "Sok Admin" -> "SA", "Admin" -> "AD")
        if (count($words) >= 2) {
            $initials = strtoupper(substr($words[0], 0, 1) . substr($words[1], 0, 1));
        } else {
            $initials = strtoupper(substr($name, 0, 2));
        }

        echo json_encode([
            'status' => 'success',
            'data'   => [
                'name'  => $user['name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'initials' => $initials
            ]
        ]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'User not found']);
    }
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>