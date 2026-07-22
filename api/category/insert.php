<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$data = json_decode(file_get_contents("php://input"), true);
$name = trim($data['name'] ?? '');

if (empty($name)) {
    echo json_encode(['status' => 'error', 'message' => 'Category name is required']);
    exit;
}

// Helper function to create a URL-friendly slug
function makeSlug($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    return empty($text) ? 'n-a' : $text;
}

$slug = makeSlug($name);

try {
    // Include the slug column in your INSERT query
    $stmt = $pdo->prepare("INSERT INTO tbl_categories (name, slug) VALUES (?, ?)");
    $stmt->execute([$name, $slug]);

    echo json_encode(['status' => 'success', 'message' => 'Category created successfully']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>