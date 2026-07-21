<?php
// ============================================
// Database Connection (PDO)
// ============================================
$host = 'localhost';
$dbname = 'team4_cinema';
$username = 'root';
$password = '3326'; // put your MySQL password here

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]
        
    );
    
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'message' => 'DB Connection failed: ' . $e->getMessage()]));
}