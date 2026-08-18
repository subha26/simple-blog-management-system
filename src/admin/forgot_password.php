<?php

require_once "../config/session.php";
require_once "../config/database.php";

$error = "";
$securityQuestion = "";
$username = "";

/*
|--------------------------------------------------------------------------
| Step 1: Find the user's security question
|--------------------------------------------------------------------------
*/

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"] ?? "");

    if (empty($username)) {

        $error = "Please enter your username.";

    } else {

        $stmt = $pdo->prepare(
            "SELECT id, username, security_question
             FROM users
             WHERE username = ?"
        );

        $stmt->execute([$username]);

        $user = $stmt->fetch();

        if (!$user) {

            $error = "Username not found.";

        } elseif (empty($user["security_question"])) {

            $error = "No security question has been configured for this account.";

        } else {

            $securityQuestion = $user["security_question"];
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

                    <h2 class="mb-4">
                        Forgot Password
                    </h2>

                    <?php if ($error): ?>

                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>

                    <?php endif; ?>


                    <?php if ($securityQuestion): ?>

                        <!-- Step 2 -->

                        <form
                            method="POST"
                            action="reset_password.php">

                            <input
                                type="hidden"
                                name="username"
                                value="<?= htmlspecialchars($username) ?>">

                            <div class="mb-3">

                                <label class="form-label">
                                    Security Question
                                </label>

                                <input
                                    type="text"
                                    class="form-control"
                                    value="<?= htmlspecialchars($securityQuestion) ?>"
                                    readonly>

                            </div>


                            <div class="mb-3">

                                <label class="form-label">
                                    Your Answer
                                </label>

                                <input
                                    type="text"
                                    name="security_answer"
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

                                Reset Password

                            </button>

                        </form>


                    <?php else: ?>

                        <!-- Step 1 -->

                        <form method="POST">

                            <div class="mb-3">

                                <label class="form-label">
                                    Username
                                </label>

                                <input
                                    type="text"
                                    name="username"
                                    class="form-control"
                                    required>

                            </div>


                            <button
                                type="submit"
                                class="btn btn-primary w-100">

                                Continue

                            </button>

                        </form>

                    <?php endif; ?>


                    <div class="text-center mt-3">

                        <a href="login.php">
                            Back to Login
                        </a>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>