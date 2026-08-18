<?php

require_once '../includes/session.php';
require_once "../config/auth.php";
require_once "../config/database.php";

include "../includes/header.php";
include "../includes/navbar.php";

$posts = $pdo->query("
SELECT *
FROM posts
ORDER BY created_at DESC
")->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-4">

<h2>

Manage Posts

</h2>

<table class="table table-bordered">

<thead>

<tr>

<th>ID</th>

<th>Title</th>

<th>Date</th>

<th>Action</th>

</tr>

</thead>

<tbody>

<?php foreach($posts as $post): ?>

<tr>

<td>

<?= $post["id"] ?>

</td>

<td>

<?= htmlspecialchars($post["title"]) ?>

</td>

<td>

<?= $post["created_at"] ?>

</td>

<td>

<a

href="edit_post.php?id=<?= $post["id"] ?>"

class="btn btn-warning btn-sm">

Edit

</a>

<a

href="delete_post.php?id=<?= $post["id"] ?>"

class="btn btn-danger btn-sm"

onclick="return confirm('Delete this post?')">

Delete

</a>

</td>

</tr>

<?php endforeach; ?>

</tbody>

</table>

    <a href="dashboard.php"
            class="btn btn-secondary">
                ← Back to Dashboard
    </a>
</div>

<?php include "../includes/footer.php"; ?>