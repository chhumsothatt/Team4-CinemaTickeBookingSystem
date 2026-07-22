<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

$id              = $_POST['id'] ?? null;
$categoryId      = $_POST['category_id'] ?? null;
$title           = trim($_POST['title'] ?? '');
$description     = trim($_POST['description'] ?? '');
$durationMinutes = $_POST['duration_minutes'] ?? null;
$releaseDate     = $_POST['release_date'] ?? null;

if (!$id || !$categoryId || empty($title) || !$durationMinutes) {
    echo json_encode(['status' => 'error', 'message' => 'Movie ID, Title, Category, and Duration are required.']);
    exit;
}

// Fetch existing poster from DB
$stmt = $pdo->prepare("SELECT poster FROM tbl_movies WHERE id = ?");
$stmt->execute([$id]);
$currentMovie = $stmt->fetch();

if (!$currentMovie) {
    echo json_encode(['status' => 'error', 'message' => 'Movie not found.']);
    exit;
}

$posterFilename = $currentMovie['poster']; // Default to existing poster

// Handle new poster file upload if provided
if (isset($_FILES['poster']) && $_FILES['poster']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath   = $_FILES['poster']['tmp_name'];
    $fileName      = $_FILES['poster']['name'];
    $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

    $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($fileExtension, $allowedExtensions)) {
        $posterFilename = uniqid('movie_', true) . '.' . $fileExtension;
        $uploadFileDir  = '../../upload/';

        if (!is_dir($uploadFileDir)) {
            mkdir($uploadFileDir, 0755, true);
        }

        $destPath = $uploadFileDir . $posterFilename;
        if (!move_uploaded_file($fileTmpPath, $destPath)) {
            echo json_encode(['status' => 'error', 'message' => 'Failed to move newly uploaded image.']);
            exit;
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid file format. Only JPG, PNG, and WEBP allowed.']);
        exit;
    }
}

try {
    $sql = "UPDATE tbl_movies 
            SET category_id = ?, title = ?, description = ?, poster = ?, duration_minutes = ?, release_date = ? 
            WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$categoryId, $title, $description, $posterFilename, $durationMinutes, $releaseDate, $id]);

    echo json_encode(['status' => 'success', 'message' => 'Movie updated successfully!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>