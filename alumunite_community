<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized access");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $content = trim($_POST['content']);
    $media = NULL;

    if (strlen($content) > 200) {
        die("Content exceeds 200 characters");
    }

    if (!empty($_FILES['media']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["media"]["name"]);
        move_uploaded_file($_FILES["media"]["tmp_name"], $target_file);
        $media = $target_file;
    }

    $stmt = $pdo->prepare("INSERT INTO posts (user_id, content, media) VALUES (?, ?, ?)");
    $stmt->execute([$user_id, $content, $media]);

    echo "Post created successfully!";
}
?>
