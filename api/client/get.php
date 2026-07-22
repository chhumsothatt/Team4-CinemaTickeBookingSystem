<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $category_id = isset($_GET['category_id']) ? trim($_GET['category_id']) : '';

    // Query ទាញទិន្នន័យពី tbl_movies និងឈ្មោះ category ពី tbl_categories
    $sql = "SELECT m.id, m.category_id, m.title, m.description, m.poster, 
                   m.duration_minutes, m.release_date, c.name AS category_name 
            FROM tbl_movies m 
            INNER JOIN tbl_categories c ON m.category_id = c.id 
            WHERE 1=1";
    
    $params = [];

    // Filter តាមចំណងជើងភាពយន្ត (title)
    if (!empty($search)) {
        $sql .= " AND m.title LIKE :search";
        $params[':search'] = '%' . $search . '%';
    }

    // Filter តាម Category ID (category_id)
    if (!empty($category_id)) {
        $sql .= " AND m.category_id = :category_id";
        $params[':category_id'] = $category_id;
    }

    $sql .= " ORDER BY m.id DESC";

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