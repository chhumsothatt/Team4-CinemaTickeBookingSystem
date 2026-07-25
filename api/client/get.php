<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $category_id = isset($_GET['category_id']) ? trim($_GET['category_id']) : '';

    $sql = "SELECT m.id, m.category_id, m.title, m.description, m.poster, 
                   m.duration_minutes, m.release_date, 
                   COALESCE(c.name, 'Uncategorized') AS category_name 
            FROM tbl_movies m 
            INNER JOIN tbl_showtimes s ON m.id = s.movie_id
            LEFT JOIN tbl_categories c ON m.category_id = c.id 
            WHERE 1=1";
    
    $params = [];

    if (!empty($search)) {
        $sql .= " AND m.title LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    if (!empty($category_id)) {
        $sql .= " AND m.category_id = :category_id";
        $params[':category_id'] = $category_id;
    }

    $sql .= " GROUP BY m.id ORDER BY m.id DESC";

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $movies
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Database Error: ' . $e->getMessage()
    ]);
}
?>