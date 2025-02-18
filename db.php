<?php
$host = 'sql103.infinityfree.com';
$dbname = 'if0_38264906_XXX';
$user = 'if0_38264906'; // Change as needed
$pass = 'YhXx1EfyEC'; // Change as needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
