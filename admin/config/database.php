<?php
/**
 * 🌟 Baganix Admin Portal Database Configuration
 * File: admin/config/database.php
 * Path: mypanel.baganix.online
 */

require_once __DIR__ . '/../../config/BaganixEnv.php';

try {
    BaganixEnv::load(__DIR__ . '/../../.env');
} catch (Exception $e) {
    die("Admin Config Error: " . $e->getMessage());
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
    die("Database Connection Error (Admin Module).");
}

// Ensure Admin Session exists for this portal
session_start();
?>