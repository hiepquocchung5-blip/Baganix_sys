<?php
/**
 * 🌟 Baganix Web Frontend Database Configuration
 * File: user-web/config/database.php
 * Path: w.baganix.online
 */

// Load the OOP Env parser from the root directory
require_once __DIR__ . '/../../config/BaganixEnv.php';

try {
    BaganixEnv::load(__DIR__ . '/../../.env');
} catch (Exception $e) {
    die("Configuration Error: " . $e->getMessage());
}

define('DB_HOST', BaganixEnv::get('DB_HOST', 'localhost'));
define('DB_USER', BaganixEnv::get('DB_USER', 'root'));
define('DB_PASS', BaganixEnv::get('DB_PASS', ''));
define('DB_NAME', BaganixEnv::get('DB_NAME', 'baganix_db'));

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->set_charset("utf8mb4"); 
} catch (mysqli_sql_exception $e) {
    // Return HTML error for the web frontend
    die("<div style='background: #1e1e2d; color: white; padding: 20px; font-family: sans-serif;'>
            <h2>System Offline</h2>
            <p>We are currently undergoing maintenance. Please check back later.</p>
         </div>");
}
?>