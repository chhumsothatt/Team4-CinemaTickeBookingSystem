<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

try {
    // Make sure table names match your schema: tbl_categories and tbl_movies
    $sql = "SELECT c.id, c.name, COUNT(m.id) AS movie_count 
            FROM tbl_categories c 
            LEFT JOIN tbl_movies m ON c.id = m.category_id 
            GROUP BY c.id 
            ORDER BY c.id DESC";


    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $categories = $stmt->fetchAll();

    echo json_encode(['status' => 'success', 'data' => $categories]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>