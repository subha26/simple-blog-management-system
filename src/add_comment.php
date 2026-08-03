<?php

require_once "config/database.php";

/*
|--------------------------------------------------------------------------
| Insert Comment
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $postId = filter_input(INPUT_POST, 'post_id', FILTER_VALIDATE_INT);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $comment = trim($_POST['comment']);

    if (!$postId) {
        die("Invalid post.");
    }

    if ($name === "" || $comment === "") {
        die("Name and comment are required.");
    }

    if ($email !== "" && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    $sql = "
    INSERT INTO comments
    (post_id,name,email,comment)

    VALUES

    (?,?,?,?)
    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([

        $postId,

        $name,

        $email,

        $comment

    ]);

}

header("Location: post.php?id=".$postId);

exit;