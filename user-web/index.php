<?php
/**
 * 🌟 Baganix Front-End Application
 * Domain: w.Baganix.online
 * Pure PHP SPA Router
 */
session_start();

// Simple routing mechanism
$page = $_GET['page'] ?? 'login';
$allowed_pages = ['login', 'feed', 'chat', 'profile'];

if (!in_array($page, $allowed_pages)) {
    $page = 'login';
}
?>
<!DOCTYPE html>
<html lang="my">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Baganix | The Next-Gen Ecosystem</title>
    
    <!-- 🌟 Include all CDNs and Local Assets here -->
    <?php include "includes/cdn.php"; ?>

</head>
<body>
    <!-- Dynamic Aurora Background -->
    <div class="aurora-bg" id="auroraBg"></div>

    <!-- Main App Container (Glassmorphism) + Animate.css FadeIn -->
    <main class="glass-container animate__animated animate__fadeIn" id="appRoot">
        <?php include "pages/{$page}.php"; ?>
    </main>

</body>
</html>