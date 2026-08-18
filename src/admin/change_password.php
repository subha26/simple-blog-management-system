<?php

require_once "../config/session.php";
require_once "../config/auth.php";
require_once "../config/database.php";

$error = "";
$success = "";

/*
|--------------------------------------------------------------------------
| Change password for the currently logged-in administrator
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $currentPassword = $_POST["current_password"] ?? "";
    $newPassword = $_POST["new_password"] ?? "";
    $confirmPassword = $_POST["confirm_password"] ?? "";

    if (
        empty($currentPassword) ||
        empty($newPassword) ||
        empty($confirmPassword)
    ) {

        $error = "All fields are required.";

    } elseif ($newPassword !== $confirmPassword) {

        $error = "New password and confirmation password do not match.";

    } elseif (strlen($newPassword) < 6) {

        $error = "New password must contain at least 6 characters.";

    } else {

        /* Get the current password hash */
        $stmt = $pdo->prepare(
            "SELECT password FROM users WHERE id = ?"
        );

        $stmt->execute([$_SESSION["user_id"]]);

        $user = $stmt->fetch();

        if (!$user) {

            $error = "User account could not be found.";

        } elseif (!password_verify($currentPassword, $user["password"])) {

            $error = "Current password is incorrect.";

        } else {

            /* Generate secure hash for the new password */
            $newPasswordHash = password_hash(
                $newPassword,
                PASSWORD_DEFAULT
            );

            $stmt = $pdo->prepare(
                "UPDATE users SET password = ? WHERE id = ?"
            );

            $stmt->execute([
                $newPasswordHash,
                $_SESSION["user_id"]
            ]);

            $success = "Password changed successfully.";
        }
    }
}

include "../includes/header.php";
include "../includes/navbar.php";

?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-center mb-4">

                        <h2 class="mb-0">
                            Change Password
                        </h2>

                        <a href="dashboard.php"
                            class="btn btn-secondary">
                                ← Cancel & back to Dashboard
                        </a>

                    </div>

                    <?php if ($error): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>


                    <?php if ($success): ?>

                        <div class="alert alert-success">
                            <?= htmlspecialchars($success) ?>
                        </div>

                    <?php endif; ?>


                    <form method="POST">

                        <div class="mb-3">

                            <label class="form-label">
                                Current Password
                            </label>

                            <input
                                type="password"
                                name="current_password"
                                class="form-control"
                                required>

                        </div>


                        <div class="mb-3">

                            <label class="form-label">
                                New Password
                            </label>

                            <input
                                type="password"
                                name="new_password"
                                class="form-control"
                                required>

                        </div>


                        <div class="mb-4">

                            <label class="form-label">
                                Confirm New Password
                            </label>

                            <input
                                type="password"
                                name="confirm_password"
                                class="form-control"
                                required>

                        </div>


                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            Change Password

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>