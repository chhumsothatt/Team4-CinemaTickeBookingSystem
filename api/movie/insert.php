<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$categoryId      = $_POST['category_id'] ?? null;
$title           = trim($_POST['title'] ?? '');
$description     = trim($_POST['description'] ?? '');
$durationMinutes = $_POST['duration_minutes'] ?? null;
$releaseDate     = $_POST['release_date'] ?? null;

if (!$categoryId || empty($title) || !$durationMinutes) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields (Title, Category, Duration).']);
    exit;
}

$posterFilename = null;

// Handle File Upload
if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['poster']['tmp_name'];
    $fileName    = $_FILES['poster']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($fileExtension, $allowedExtensions)) {
        // Generate unique filename
        $posterFilename = uniqid('movie_', true) . '.' . $fileExtension;
        $uploadFileDir  = '../../upload/';

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $destPath = $uploadFileDir . $posterFilename;
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move uploaded image.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file type. Only JPG, PNG, and WEBP allowed.']);
        exit;
    }
}

try {
    $sql = "INSERT INTO tbl_movies (category_id, title, description, poster, duration_minutes, release_date) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoryId, $title, $description, $posterFilename, $durationMinutes, $releaseDate]);

    echo json_encode(['status' => 'success', 'message' => 'Movie added successfully!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>