<?php

$isLoggedIn = isset($_SESSION['user_id']);

// Are we currently inside /admin/ ?
$isAdminPage = strpos($_SERVER['PHP_SELF'], '/admin/') !== false;

?>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand"
           href="<?= $isAdminPage ? '../index.php' : 'index.php'; ?>">
            Simple Blog
        </a>

        <div class="d-flex align-items-center">

            <?php if ($isLoggedIn): ?>

                <span class="text-white me-3">
                    Welcome,
                    <strong>
                        <?= htmlspecialchars($_SESSION['full_name'] ?? 'Administrator') ?>
                    </strong>
                </span>

                <?php if ($isAdminPage): ?>

                    <a href="../index.php"
                       class="btn btn-outline-light me-2">
                        View Website
                    </a>

                    <a href="../logout.php"
                       class="btn btn-danger">
                        Logout
                    </a>

                <?php else: ?>

                    <a href="admin/dashboard.php"
                       class="btn btn-outline-light me-2">
                        View Dashboard
                    </a>

                    <a href="logout.php"
                       class="btn btn-danger">
                        Logout
                    </a>

                <?php endif; ?>

            <?php else: ?>

                <a href="admin/login.php"
                   class="btn btn-outline-light">
                    Admin Login
                </a>

            <?php endif; ?>

        </div>

    </div>
</nav>