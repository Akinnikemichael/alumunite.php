<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $post_id = $_POST['post_id'] ?? NULL;
    $comment_id = $_POST['comment_id'] ?? NULL;

    $stmt = $pdo->prepare("INSERT INTO likes (user_id, post_id, comment_id) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE id=id");
    $stmt->execute([$user_id, $post_id, $comment_id]);

    echo "Liked successfully!";
}
?>
