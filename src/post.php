<?php

require_once "includes/session.php";
require_once "config/database.php";

include "includes/header.php";
include "includes/navbar.php";

/*
|--------------------------------------------------------------------------
| Validate post id
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {

    die("Invalid post.");

}

$postId = (int)$_GET['id'];

/*
|--------------------------------------------------------------------------
| Fetch selected post
|--------------------------------------------------------------------------
*/

$sql = "
SELECT posts.*,
       users.full_name
FROM posts
JOIN users
ON posts.author_id = users.id
WHERE posts.id = ?
";

$stmt = $pdo->prepare($sql);

$stmt->execute([$postId]);

$post = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$post) {

    die("Post not found.");

}
?>

<div class="container mt-4">

    <div class="card shadow">

        <div class="card-body">

            <h2>

                <?= htmlspecialchars($post['title']) ?>

            </h2>

            <p class="text-muted">

                By

                <strong>

                    <?= htmlspecialchars($post['full_name']) ?>

                </strong>

                |

                <?= $post['created_at'] ?>

            </p>

            <hr>

            <p style="white-space: pre-line;">

                <?= htmlspecialchars($post['content']) ?>

            </p>

        </div>

    </div>

    <?php

/*
|--------------------------------------------------------------------------
| Fetch Comments
|--------------------------------------------------------------------------
*/

$sql = "
SELECT *
FROM comments
WHERE post_id = ?
AND status='approved'
ORDER BY created_at DESC
";

$stmt = $pdo->prepare($sql);

$stmt->execute([$postId]);

$comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="mt-5">

    <h3>

        Comments

    </h3>

    <hr>

    <?php if(count($comments)==0): ?>

        <p>

            No comments yet.

        </p>

    <?php endif; ?>

    <?php foreach($comments as $comment): ?>

        <div class="card mb-3">

            <div class="card-body">

                <strong>

                    <?= htmlspecialchars($comment['name']) ?>

                </strong>

                <small class="text-muted">

                    <?= $comment['created_at'] ?>

                </small>

                <hr>

                <?= nl2br(htmlspecialchars($comment['comment'])) ?>

            </div>

        </div>

    <?php endforeach; ?>

</div>

<div class="mt-5">

<h3>

Leave a Comment

</h3>

<form
action="add_comment.php"
method="POST">

<input
type="hidden"
name="post_id"
value="<?= $postId ?>">

<div class="mb-3">

<label class="form-label">

Name

</label>

<input
type="text"
class="form-control"
name="name"
required>

</div>

<div class="mb-3">

<label class="form-label">

Email

</label>

<input
type="email"
class="form-control"
name="email">

</div>

<div class="mb-3">

<label class="form-label">

Comment

</label>

<textarea
class="form-control"
name="comment"
rows="5"
required></textarea>

</div>

<button
class="btn btn-success">

Submit Comment

</button>

</form>

</div>

</div>

<div class="d-flex align-items-center justify-content-center mt-4">

    <a href="index.php"
        class="btn btn-secondary">
            ← Back to All Posts
    </a>
</div>

<?php

include "includes/footer.php";

?>