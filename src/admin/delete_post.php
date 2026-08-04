<?php

require_once "../config/auth.php";
require_once "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if ($id) {

    $stmt = $pdo->prepare("DELETE FROM posts WHERE id=?");

    $stmt->execute([$id]);

}

header("Location: manage_posts.php");

exit;