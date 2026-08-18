<?php

require_once "../config/session.php";
require_once "../config/database.php";

$error = "";
$success = "";

/*
|--------------------------------------------------------------------------
| Reset password using the security answer
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] !== "POST") {

    header("Location: forgot_password.php");
    exit;
}

$username = trim($_POST["username"] ?? "");
$securityAnswer = trim($_POST["security_answer"] ?? "");
$newPassword = $_POST["new_password"] ?? "";
$confirmPassword = $_POST["confirm_password"] ?? "";


if (
    empty($username) ||
    empty($securityAnswer) ||
    empty($newPassword) ||
    empty($confirmPassword)
) {

    $error = "All fields are required.";

} elseif ($newPassword !== $confirmPassword) {

    $error = "New password and confirmation password do not match.";

} elseif (strlen($newPassword) < 6) {

    $error = "New password must contain at least 6 characters.";

} else {

    /*
    |--------------------------------------------------------------------------
    | Find User
    |--------------------------------------------------------------------------
    */

    $stmt = $pdo->prepare(
        "SELECT id, security_answer
         FROM users
         WHERE username = ?"
    );

    $stmt->execute([$username]);

    $user = $stmt->fetch();


    if (!$user || empty($user["security_answer"])) {

        $error = "Password reset could not be completed.";

    } elseif (
        !password_verify(
            $securityAnswer,
            $user["security_answer"]
        )
    ) {

        $error = "Security answer is incorrect.";

    } else {

        /*
        |--------------------------------------------------------------------------
        | Update Password
        |--------------------------------------------------------------------------
        */

        $newPasswordHash = password_hash(
            $newPassword,
            PASSWORD_DEFAULT
        );

        $stmt = $pdo->prepare(
            "UPDATE users
             SET password = ?
             WHERE id = ?"
        );

        $stmt->execute([
            $newPasswordHash,
            $user["id"]
        ]);

        $success = "Password reset successfully. You can now log in.";
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

                    <h2 class="mb-4">
                        Reset Password
                    </h2>


                    <?php if ($error): ?>

                        <div class="alert alert-danger">

                            <?= htmlspecialchars($error) ?>

                        </div>

                        <a href="forgot_password.php"
                           class="btn btn-secondary">

                            Try Again

                        </a>

                    <?php endif; ?>


                    <?php if ($success): ?>

                        <div class="alert alert-success">

                            <?= htmlspecialchars($success) ?>

                        </div>

                        <a href="login.php"
                           class="btn btn-primary">

                            Go to Login

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>