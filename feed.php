<?php
session_start();
require 'db.php';

$stmt = $pdo->query("
    SELECT p.id, p.content, p.media, p.created_at, u.username,
           (SELECT COUNT(*) FROM likes WHERE post_id = p.id) AS like_count
    FROM posts p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
");

$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($posts as $post) {
    echo "<div>";
    echo "<strong>{$post['username']}</strong>: {$post['content']} <br>";
    if ($post['media']) echo "<img src='{$post['media']}' width='200'><br>";
    echo "Likes: {$post['like_count']} <br>";

    echo "<form action='like.php' method='POST'>
        <input type='hidden' name='post_id' value='{$post['id']}'>
        <button type='submit'>Like</button>
    </form>";

    echo "<form action='comment.php' method='POST'>
        <input type='hidden' name='post_id' value='{$post['id']}'>
        <textarea name='content'></textarea>
        <button type='submit'>Comment</button>
    </form>";

    $stmt = $pdo->prepare("SELECT c.id, c.content, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE post_id = ?");
    $stmt->execute([$post['id']]);
    $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($comments as $comment) {
        echo "<p><strong>{$comment['username']}</strong>: {$comment['content']}</p>";
    }

    echo "</div><hr>";
}
?>
