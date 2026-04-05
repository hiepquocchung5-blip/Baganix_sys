<?php
/**
 * 🌟 Baganix Database Configuration (API Portal)
 * File: api/config/database.php
 */

// 1. 🛡️ CORS MUST BE THE VERY FIRST THING PROCESSED
// This dynamically allows your local testing (localhost) AND your production domain
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
} else {
    header("Access-Control-Allow-Origin: https://w.baganix.online");
}
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Instantly resolve Preflight OPTIONS requests before doing any heavy PHP work
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit(0);
}

// Initialize JSON header early for API responses
header('Content-Type: application/json');

// 2. Load the OOP Env parser
require_once __DIR__ . '/BaganixEnv.php';

try {
    // Load the .env file from the root directory (Baganix/.env)
    BaganixEnv::load(__DIR__ . '/../../.env');
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["status" => "error", "message" => "ENV Error: " . $e->getMessage()]);
    exit;
}

// Define global configuration constants
define('DB_HOST', BaganixEnv::get('DB_HOST', 'localhost'));
define('DB_USER', BaganixEnv::get('DB_USER', 'root'));
define('DB_PASS', BaganixEnv::get('DB_PASS', ''));
define('DB_NAME', BaganixEnv::get('DB_NAME', 'baganix_db'));

// Enable strict MySQLi error reporting
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Initialize pure MySQLi connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $db->set_charset("utf8mb4"); 
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database Connection Failed",
        "debug" => BaganixEnv::get('APP_ENV') === 'development' ? $e->getMessage() : 'Hidden for security'
    ]);
    exit;
}
?>