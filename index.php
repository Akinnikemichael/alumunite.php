<?php
session_start();
require 'db.php';

// Fetch posts
$stmt = $pdo->query("
    SELECT p.id, p.content, p.media, p.created_at, u.username,
           (SELECT COUNT(*) FROM likes WHERE post_id = p.id) AS like_count
    FROM posts p
    JOIN users u ON p.user_id = u.id
    ORDER BY p.created_at DESC
");
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<?php if (isset($_SESSION['user_id'])): ?>
    <a href="logout.php">Logout</a>
    <h2>Create a Post</h2>
    <form action="create_post.php" method="POST" enctype="multipart/form-data">
        <textarea name="content" placeholder="Write something..." required maxlength="200"></textarea>
        <input type="file" name="media" accept="image/*,video/*">
        <button type="submit">Post</button>
    </form>
<?php else: ?>
    <a href="login.php">Login</a> | <a href="register.php">Register</a>
<?php endif; ?>

<hr>

<h2>Posts</h2>
<?php foreach ($posts as $post): ?>
    <div class="post">
        <strong><?= htmlspecialchars($post['username']) ?></strong>: 
        <?= htmlspecialchars($post['content']) ?> <br>
        <?php if ($post['media']): ?>
            <img src="<?= htmlspecialchars($post['media']) ?>" width="200"><br>
        <?php endif; ?>
        Likes: <?= $post['like_count'] ?> <br>

        <form action="like.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <button type="submit">Like</button>
        </form>

        <form action="comment.php" method="POST">
            <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
            <textarea name="content" placeholder="Write a comment..." required></textarea>
            <button type="submit">Comment</button>
        </form>

        <h4>Comments:</h4>
        <?php
        $stmt = $pdo->prepare("SELECT c.id, c.content, u.username FROM comments c JOIN users u ON c.user_id = u.id WHERE post_id = ?");
        $stmt->execute([$post['id']]);
        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <?php foreach ($comments as $comment): ?>
            <p><strong><?= htmlspecialchars($comment['username']) ?>:</strong> <?= htmlspecialchars($comment['content']) ?></p>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>

</body>
</html>
