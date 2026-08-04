<?php

require_once "config/database.php";

include "includes/header.php";
include "includes/navbar.php";

/*
|--------------------------------------------------------------------------
| Fetch all blog posts
|--------------------------------------------------------------------------
*/

$query = $pdo->query("
    SELECT *
    FROM posts
    ORDER BY created_at DESC
");

$posts = $query->fetchAll(PDO::FETCH_ASSOC);

?>

<div class="container mt-4">

    <h2 class="mb-4">

        Latest Posts

    </h2>

    <?php foreach($posts as $post): ?>

        <div class="card shadow-sm">

            <div class="card-body">

                <h3>

                    <?= htmlspecialchars($post['title']) ?>

                </h3>

                <p class="text-muted">

                    Published on

                    <?= date("d M Y", strtotime($post['created_at'])) ?>

                </p>

                <p>

                    <?= substr(htmlspecialchars($post['content']),0,180) ?>

                    ...

                </p>

                <a
                href="post.php?id=<?= $post['id'] ?>"
                class="btn btn-primary">

                    Read More

                </a>

            </div>

        </div>

    <?php endforeach; ?>

</div>

<?php

include "includes/footer.php";

?>