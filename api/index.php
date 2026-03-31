<?php
/**
 * 🌟 Baganix API Portal Root
 * Domain: api.Baganix.online
 */

header('Content-Type: application/json');

// A premium welcome message for the API root
echo json_encode([
    "platform" => "Baganix Next-Gen Social Ecosystem",
    "status" => "online",
    "version" => "1.0.0",
    "timezone" => "Asia/Yangon",
    "message" => "Welcome to the Baganix API. Navigate to /v1/ for endpoints.",
    "documentation" => "https://admin.baganix.online/docs"
]);
?>