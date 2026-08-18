<?php

require_once '../includes/session.php';
require_once "../config/auth.php";
require_once "../config/database.php";
require_once "../includes/functions.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    /*
    |--------------------------------------------------------------------------
    | Generate slug
    |--------------------------------------------------------------------------
    */

    $slug = createSlug($title);

    $slug = preg_replace('/[^a-z0-9]+/', '-', $slug);

    $slug = trim($slug, '-');

    $sql = "

    INSERT INTO posts

    (title,slug,content,author_id)

    VALUES

    (?,?,?,?)

    ";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([

        $title,

        $slug,

        $content,

        $_SESSION["user_id"]

    ]);

    $message = "Post published successfully.";

}

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-body">

<!-- Flex container to align heading and button side-by-side -->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Create Blog Post</h2>
                <a href="dashboard.php" class="btn btn-secondary">
                    ← Back to Dashboard
                </a>
            </div>


<?php if($message): ?>

<div class="alert alert-success">

<?= $message ?>

</div>

<?php endif; ?>

<form method="POST">

<div class="mb-3">

<label>

Title

</label>

<input

type="text"

name="title"

class="form-control"

required>

</div>

<div class="mb-3">

<label>

Content

</label>

<textarea

name="content"

rows="12"

class="form-control"

required></textarea>

</div>

<button

class="btn btn-success">

Publish

</button>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>