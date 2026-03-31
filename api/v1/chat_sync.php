<?php
/**
 * 🌟 Baganix End-to-End Encrypted Chat Sync
 * Endpoint: api.Baganix.online/v1/chat_sync.php
 * Note: PHP NEVER sees the plain text. It only handles routing hashes.
 */

require_once '../../config/database.Baganix.online.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$action = $_GET['action'] ?? '';

if ($method === 'POST' && $action === 'send') {
    // 1. Receive an encrypted payload from User A to User B
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->sender_id) || !isset($data->receiver_id) || !isset($data->encrypted_payload)) {
        echo json_encode(["status" => "error", "message" => "Missing hash parameters."]);
        exit;
    }

    $stmt = $db->prepare("INSERT INTO chat_hashes (sender_id, receiver_id, encrypted_payload) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $data->sender_id, $data->receiver_id, $data->encrypted_payload);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Encrypted payload routed to Vault."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Routing failed."]);
    }
    $stmt->close();

} elseif ($method === 'GET' && $action === 'sync') {
    // 2. Fetch all unread encrypted hashes for the logged-in user
    if (!isset($_GET['user_id'])) {
        echo json_encode(["status" => "error", "message" => "User ID required."]);
        exit;
    }

    $user_id = (int)$_GET['user_id'];
    
    $stmt = $db->prepare("SELECT id, sender_id, encrypted_payload, created_at FROM chat_hashes WHERE receiver_id = ? AND is_read = FALSE ORDER BY created_at ASC");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $hashes = [];
    $ids_to_mark_read = [];
    
    while ($row = $result->fetch_assoc()) {
        $hashes[] = $row;
        $ids_to_mark_read[] = $row['id'];
    }
    
    // Mark them as read automatically once fetched by the client Vault
    if (!empty($ids_to_mark_read)) {
        $id_list = implode(",", $ids_to_mark_read);
        $db->query("UPDATE chat_hashes SET is_read = TRUE WHERE id IN ($id_list)");
    }
    
    echo json_encode([
        "status" => "success", 
        "info" => "Decrypt these locally using your private key.",
        "payloads" => $hashes
    ]);
    $stmt->close();
}
?>