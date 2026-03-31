<?php
/**
 * 🌟 Baganix Database Configuration (API Portal)
 * File: api/config/database.php
 * Portal-specific configuration utilizing the global OOP Env parser.
 */

// Adjust this path if you moved BaganixEnv.php somewhere else
require_once __DIR__ . '/../../config/BaganixEnv.php';

// Initialize JSON header early for API responses
header('Content-Type: application/json');

try {
    // Load the .env file from the root directory (Baganix/.env)
    BaganixEnv::load(__DIR__ . '/../../.env');
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => $e->getMessage()]);
    exit;
}

// Define global configuration constants using the Env getter
define('DB_HOST', BaganixEnv::get('DB_HOST', 'localhost'));
define('DB_USER', BaganixEnv::get('DB_USER', 'root'));
define('DB_PASS', BaganixEnv::get('DB_PASS', ''));
define('DB_NAME', BaganixEnv::get('DB_NAME', 'baganix_db'));

// Enable strict MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Initialize pure MySQLi connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->set_charset("utf8mb4"); // Enforce Burmese Unicode
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database Connection Failed",
        "debug" => BaganixEnv::get('APP_ENV') === 'development' ? $e->getMessage() : 'Hidden for security'
    ]);
    exit;
}

// Global CORS Headers specific to the API portal
header("Access-Control-Allow-Origin: *"); 
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
?>