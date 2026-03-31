<?php
/**
 * 🌟 Baganix Users/Contacts API
 * Endpoint: api.baganix.online/v1/users.php
 * Fetches available contacts and their Public Keys for E2EE.
 */

require_once '../config/database.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // In a production app, you would verify the JWT token here.
    // We will fetch all users except the current user (if passed via query param)
    $current_user_id = isset($_GET['current_user_id']) ? (int)$_GET['current_user_id'] : 0;
    
    // Fetch users. We MUST include the public_key so the sender can encrypt messages.
    $query = "SELECT id, username, aura_colors, public_key FROM users WHERE id != ? ORDER BY username ASC";
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $current_user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    
    echo json_encode(["status" => "success", "data" => $users]);
    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Method not allowed."]);
}
?>