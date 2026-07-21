<?php
// ============================================
// Middleware: Auth Check
// ============================================
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Use inside AJAX handlers (returns JSON 401)
function requireAuthAjax()
{
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'message' => 'សូម Login មុននឹងបន្ត']);
        exit;
    }
}
// Use inside admin pages (redirects to login.php)
function requireAuthPage()
{
    if (!isset($_SESSION['user_id'])) {
        header('Location: ../login.php');
        exit;
    }

    if (($_SESSION['user_role'] ?? '') !== 'admin') {
        header('Location: ../client/index.php');
        exit;
    }
}
