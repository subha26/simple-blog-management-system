<?php

require_once "../config/session.php";
require_once "../config/auth.php";
require_once "../config/database.php";

/*
|--------------------------------------------------------------------------
| Get comment statistics for each blog post
|--------------------------------------------------------------------------
|
| LEFT JOIN ensures that posts with zero comments are also displayed.
|
*/

$sql = "
    SELECT
        posts.id,
        posts.title,
        posts.created_at,
        COUNT(comments.id) AS total_comments,

        SUM(
            CASE
                WHEN comments.status = 'pending' THEN 1
                ELSE 0
            END
        ) AS pending_comments,

        SUM(
            CASE
                WHEN comments.status = 'approved' THEN 1
                ELSE 0
            END
        ) AS approved_comments

    FROM posts

    LEFT JOIN comments
        ON posts.id = comments.post_id

    GROUP BY
        posts.id,
        posts.title,
        posts.created_at

    ORDER BY posts.created_at DESC
";

$stmt = $pdo->query($sql);
$posts = $stmt->fetchAll();

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2>Comment Management</h2>

            <p class="text-muted mb-0">
                View comment statistics for each blog post.
            </p>
        </div>

        <a href="dashboard.php"
           class="btn btn-secondary">
            ← Back to Dashboard
        </a>

    </div>


    <?php if (count($posts) > 0): ?>

        <div class="card shadow">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover mb-0">

                        <thead class="table-dark">

                            <tr>

                                <th>Blog Post</th>

                                <th class="text-center">
                                    Total
                                </th>

                                <th class="text-center">
                                    Pending
                                </th>

                                <th class="text-center">
                                    Approved
                                </th>

                                <th class="text-center">
                                    Action
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($posts as $post): ?>

                                <tr>

                                    <td>

                                        <strong>
                                            <?= htmlspecialchars($post["title"]) ?>
                                        </strong>

                                    </td>

                                    <td class="text-center">

                                        <?= $post["total_comments"] ?>

                                    </td>

                                    <td class="text-center">

                                        <?= $post["pending_comments"] ?? 0 ?>

                                    </td>

                                    <td class="text-center">

                                        <?= $post["approved_comments"] ?? 0 ?>

                                    </td>

                                    <td class="text-center">

                                        <a
                                            href="view_comments.php?post_id=<?= $post["id"] ?>"
                                            class="btn btn-sm btn-primary">

                                            View Comments

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    <?php else: ?>

        <div class="alert alert-info">

            No blog posts found.

        </div>

    <?php endif; ?>

</div>

<?php include "../includes/footer.php"; ?>