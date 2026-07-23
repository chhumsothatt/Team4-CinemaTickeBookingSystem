<?php
header('Content-Type: application/json');
require_once '../../config/database.php';

// Helper function to safely fetch counts
function getCount($pdo, $sql) {
    try {
        $stmt = $pdo->query($sql);
        return $stmt ? (int)$stmt->fetchColumn() : 0;
    } catch (Exception $e) {
        return 0; // Return 0 if query fails or table doesn't exist yet
    }
}

// 1. MOVIES STATS
$totalMovies     = getCount($pdo, "SELECT COUNT(*) FROM tbl_movies");
$moviesThisMonth = getCount($pdo, "SELECT COUNT(*) FROM tbl_movies WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");

// 2. USERS STATS
$totalUsers      = getCount($pdo, "SELECT COUNT(*) FROM tbl_users");
$usersThisMonth  = getCount($pdo, "SELECT COUNT(*) FROM tbl_users WHERE MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE())");

// 3. BOOKINGS STATS
$totalBookings    = getCount($pdo, "SELECT COUNT(*) FROM tbl_bookings");
$bookingsThisWeek = getCount($pdo, "SELECT COUNT(*) FROM tbl_bookings WHERE YEARWEEK(created_at, 1) = YEARWEEK(CURRENT_DATE(), 1)");

// 4. CINEMA ROOMS STATS (Updated Table Name)
$totalRooms = getCount($pdo, "SELECT COUNT(*) FROM tbl_cinema_rooms");
$vipRooms   = getCount($pdo, "SELECT COUNT(*) FROM tbl_cinema_rooms WHERE LOWER(room_type) = 'vip'");

echo json_encode([
    'status' => 'success',
    'data'   => [
        'total_movies'       => number_format($totalMovies),
        'movies_this_month'  => $moviesThisMonth,
        'total_users'        => number_format($totalUsers),
        'users_this_month'   => $usersThisMonth,
        'total_bookings'     => number_format($totalBookings),
        'bookings_this_week' => $bookingsThisWeek,
        'total_rooms'        => number_format($totalRooms),
        'vip_rooms'          => $vipRooms
    ]
]);
?>