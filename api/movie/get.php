<?php
// Turn on error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');
require_once '../../config/database.php';

$search     = isset($_GET['search']) ? trim($_GET['search']) : '';
$categoryId = isset($_GET['category_id']) ? trim($_GET['category_id']) : '';

try {
    $sql = "SELECT m.*, c.name AS category_name 
            FROM tbl_movies m 
            LEFT JOIN tbl_categories c ON m.category_id = c.id 
            WHERE 1=1";
    
    $params = [];

    // Search by title if provided
    if ($search !== '') {
        $sql .= " AND m.title LIKE ?";
        $params[] = '%' . $search . '%';
    }

    // Filter by category ONLY if it's a valid ID and NOT 'all'
    if ($categoryId !== '' && $categoryId !== 'all' && $categoryId !== 'undefined') {
        $sql .= " AND m.category_id = ?";
        $params[] = $categoryId;
    }

    $sql .= " ORDER BY m.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'count'  => count($movies),
        'data'   => $movies
    ]);
} catch (PDOException $e) {
    echo json_encode([
        'status'  => 'error', 
        'message' => $e->getMessage()
    ]);
}
?>