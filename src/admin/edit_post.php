<?php

require_once '../includes/session.php';
require_once "../config/auth.php";
require_once "../config/database.php";

$id = filter_input(INPUT_GET, "id", FILTER_VALIDATE_INT);

if (!$id) {
    die("Invalid post ID.");
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=?");
$stmt->execute([$id]);
$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {
    die("Post not found.");
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = trim($_POST["title"]);
    $content = trim($_POST["content"]);

    $stmt = $pdo->prepare("
        UPDATE posts
        SET title=?, content=?
        WHERE id=?
    ");

    $stmt->execute([$title, $content, $id]);

    $message = "Post updated successfully.";

    // Refresh the post data after update
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id=?");
    $stmt->execute([$id]);
    $post = $stmt->fetch(PDO::FETCH_ASSOC);
}

include "../includes/header.php";
include "../includes/navbar.php";
?>

<div class="container mt-4">

<div class="card shadow">

<div class="card-body">

<h2>Edit Blog Post</h2>

<?php if($message): ?>
<div class="alert alert-success"><?= $message ?></div>
<?php endif; ?>

<form method="POST">

    <div class="mb-3">
        <label>Title</label>

        <input
            type="text"
            name="title"
            class="form-control"
            value="<?= htmlspecialchars($post["title"]) ?>"
            required>
    </div>

    <div class="mb-3">

        <label>Content</label>

        <textarea
            name="content"
            rows="12"
            class="form-control"
            required><?= htmlspecialchars($post["content"]) ?></textarea>

    </div>

    <div class="d-flex gap-2">

        <button type="submit" class="btn btn-primary">
            Update Post
        </button>

        <a href="edit_post.php?id=<?= $id ?>"
           class="btn btn-secondary">
            Discard Changes
        </a>

        <a href="manage_posts.php"
           class="btn btn-outline-dark">
            Back to Manage Posts
        </a>

    </div>

</form>

</div>

</div>

</div>

<?php include "../includes/footer.php"; ?>