<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['content']);

    if (strlen($content) > 200) {
        die("Content exceeds 200 characters");
    }

    $stmt = $pdo->prepare("UPDATE posts SET content = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$content, $post_id, $user_id]);

    echo "Post updated successfully!";
}
?>
