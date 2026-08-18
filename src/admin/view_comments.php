<?php

require_once "../config/session.php";
require_once "../config/auth.php";
require_once "../config/database.php";


/*
|--------------------------------------------------------------------------
| Validate Post ID
|--------------------------------------------------------------------------
*/

if (!isset($_GET["post_id"]) || !is_numeric($_GET["post_id"])) {

    header("Location: manage_comments.php");
    exit;

}

$postId = (int) $_GET["post_id"];


/*
|--------------------------------------------------------------------------
| Get Blog Post
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM posts
    WHERE id = ?
");

$stmt->execute([$postId]);

$post = $stmt->fetch();


if (!$post) {

    header("Location: manage_comments.php");
    exit;

}


/*
|--------------------------------------------------------------------------
| Get Comments for This Post
|--------------------------------------------------------------------------
*/

$stmt = $pdo->prepare("
    SELECT *
    FROM comments
    WHERE post_id = ?
    ORDER BY created_at DESC
");

$stmt->execute([$postId]);

$comments = $stmt->fetchAll();


include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2>Comments</h2>

            <p class="text-muted mb-0">

                Blog Post:

                <strong>
                    <?= htmlspecialchars($post["title"]) ?>
                </strong>

            </p>

        </div>


        <a href="manage_comments.php"
           class="btn btn-secondary">

            ← Back to Statistics

        </a>

    </div>


    <?php if (count($comments) > 0): ?>


        <?php foreach ($comments as $comment): ?>

            <div class="card shadow-sm mb-3">

                <div class="card-body">

                    <div class="d-flex justify-content-between">

                        <div>

                            <h5 class="mb-1">

                                <?= htmlspecialchars($comment["name"]) ?>

                            </h5>

                            <small class="text-muted">

                                <?= htmlspecialchars($comment["email"]) ?>

                            </small>

                        </div>


                        <span class="badge
                            <?= $comment["status"] === "approved"
                                ? "bg-success"
                                : ($comment["status"] === "pending"
                                    ? "bg-warning text-dark"
                                    : "bg-secondary") ?>">

                            <?= ucfirst(htmlspecialchars($comment["status"])) ?>

                        </span>

                    </div>


                    <hr>


                    <p class="mb-0">

                        <?= nl2br(
                            htmlspecialchars($comment["comment"])
                        ) ?>

                    </p>


                    <small class="text-muted d-block mt-3">

                        Posted on:

                        <?= htmlspecialchars($comment["created_at"]) ?>

                    </small>

                </div>

            </div>

        <?php endforeach; ?>


    <?php else: ?>


        <div class="alert alert-info">

            No comments have been submitted for this blog post yet.

        </div>


    <?php endif; ?>

</div>


<?php include "../includes/footer.php"; ?>