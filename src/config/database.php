<?php
/**
 * Database Connection
 * Using PDO for secure database access.
 */

$host = "db";
$dbname = "simple_blog";
$username = "bloguser";
$password = "blogpass";

try {

    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password
    );

    // Throw exceptions on database errors
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {

    die("Database Connection Failed: " . $e->getMessage());

}
