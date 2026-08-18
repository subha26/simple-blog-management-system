<?php

require_once '../includes/session.php';
require_once "../config/auth.php";
require_once "../config/database.php";

$postCount = $pdo->query("SELECT COUNT(*) FROM posts")->fetchColumn();

$commentCount = $pdo->query("SELECT COUNT(*) FROM comments")->fetchColumn();

$pendingCount = $pdo->query("
SELECT COUNT(*)
FROM comments
WHERE status='pending'
")->fetchColumn();

include "../includes/header.php";

include "../includes/navbar.php";

?>

<div class="row mb-4">

    <!-- Posts Card -->
    <div class="col-md-4 mb-3">

        <a href="manage_posts.php"
           class="text-decoration-none">

            <div class="card bg-primary text-white shadow h-100">

                <div class="card-body text-center">

                    <h1><?= $postCount ?></h1>

                    <h5>Total Posts</h5>

                </div>

            </div>

        </a>

    </div>

    <!-- Comments Card -->
    <div class="col-md-4 mb-3">

        <a href="manage_comments.php"
           class="text-decoration-none">

            <div class="card bg-success text-white shadow h-100">

                <div class="card-body text-center">

                    <h1><?= $commentCount ?></h1>

                    <h5>Total Comments</h5>

                </div>

            </div>

        </a>

    </div>

    <!-- Pending Card -->
    <div class="col-md-4 mb-3">

        <div class="card bg-warning shadow h-100">

            <div class="card-body text-center">

                <h1><?= $pendingCount ?></h1>

                <h5>Pending Comments</h5>

            </div>

        </div>

    </div>

</div>

<h2>

Dashboard

</h2>

<hr>

<p>

Welcome,

<strong>

<?= $_SESSION["full_name"] ?>

</strong>

</p>

<div class="list-group">

    <a href="create_post.php"
       class="list-group-item list-group-item-action">
        ➕ Create New Post
    </a>

    <a href="manage_posts.php"
       class="list-group-item list-group-item-action">
        📝 Manage Posts
    </a>

    <a href="manage_comments.php"
       class="list-group-item list-group-item-action">
        💬 Manage Comments
    </a>

    <a href="change_password.php"
       class="list-group-item list-group-item-action">
        🔐 Change Password
    </a>

    <a href="../index.php"
       class="list-group-item list-group-item-action">
        🌍 View Website
    </a>

    <a href="../logout.php"
       class="list-group-item list-group-item-action text-danger">
        🚪 Logout
    </a>

</div>

</div>

</div>

</div>

<?php

include "../includes/footer.php";

?>