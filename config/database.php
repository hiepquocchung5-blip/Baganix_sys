<?php
/**
 * 🌟 Baganix Database Configuration
 * Maps to: /config/database.Baganix.online.php
 */

// Define global configuration constants
define('DB_HOST', 'localhost'); // Change if using external DB
define('DB_USER', 'root');      // Replace with your actual DB user
define('DB_PASS', 'Stephan2k03');          // Replace with your actual DB password
define('DB_NAME', 'baganix_db');

// Enable strict MySQLi error reporting for easier debugging
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Initialize pure MySQLi connection
    $db = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Ensure Burmese Unicode (utf8mb4) is enforced on connection
    $db->set_charset("utf8mb4");
} catch (mysqli_sql_exception $e) {
    // Return a clean JSON error if DB fails (Premium API feel)
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode([
        "status" => "error",
        "message" => "Database Connection Failed",
        "debug" => $e->getMessage() // Remove this line in production!
    ]);
    exit;
}

// Global CORS Headers for the API so w.Baganix.online can communicate with api.Baganix.online
header("Access-Control-Allow-Origin: *"); // Restrict to https://w.baganix.online in production
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle Preflight OPTIONS requests for CORS
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    exit(0);
}
?>