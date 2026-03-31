<?php
/**
 * 🌟 Baganix Admin Portal (MyPanel)
 * Domain: mypanel.baganix.online
 */
session_start();
require_once 'config/database.php'; // Uses your newly created config

// Simple routing mechanism
$page = $_GET['page'] ?? 'dashboard';
$allowed_pages = ['login', 'dashboard', 'users', 'moderation'];

if (!in_array($page, $allowed_pages)) {
    $page = 'dashboard';
}

// 🛡️ Strict Auth Guard: Force login if not authenticated
if ($page !== 'login' && !isset($_SESSION['admin_id'])) {
    header("Location: ?page=login");
    exit;
}

// Handle Admin Logout
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_destroy();
    header("Location: ?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baganix Command Center | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="assets/css/admin.css">
</head>
<body>
    <?php include "pages/{$page}.php"; ?>
</body>
</html>