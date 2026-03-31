<?php
/**
 * 🌟 Baganix Posts API (Zat-Lan)
 * Endpoint: api.Baganix.online/v1/posts.php
 */

require_once '../../config/database.Baganix.online.php';
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    // Fetch Feed (Premium feature 19: No-Scroll Daily Deck simulation)
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;
    
    $query = "
        SELECT p.id, p.content, p.media_url, p.post_type, p.vibe_score, p.created_at, u.username, u.aura_colors 
        FROM posts p
        JOIN users u ON p.user_id = u.id
        ORDER BY p.created_at DESC
        LIMIT ?
    ";
    
    $stmt = $db->prepare($query);
    $stmt->bind_param("i", $limit);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $posts = [];
    while ($row = $result->fetch_assoc()) {
        $posts[] = $row;
    }
    
    echo json_encode(["status" => "success", "data" => $posts]);
    $stmt->close();

} elseif ($method === 'POST') {
    // Create a new Post/Reel
    $data = json_decode(file_get_contents("php://input"));
    
    if (!isset($data->user_id) || !isset($data->content)) {
        echo json_encode(["status" => "error", "message" => "Missing data."]);
        exit;
    }

    $user_id = (int)$data->user_id;
    $content = $data->content;
    $post_type = $data->post_type ?? 'text';
    $media_url = $data->media_url ?? null;

    $stmt = $db->prepare("INSERT INTO posts (user_id, content, post_type, media_url) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $content, $post_type, $media_url);
    
    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Post published successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Failed to create post."]);
    }
    $stmt->close();
}
?>