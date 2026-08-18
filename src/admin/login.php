<?php

require_once "../config/session.php";
require_once "../config/database.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = ?";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $user["username"];
        $_SESSION["full_name"] = $user["full_name"];

        header("Location: dashboard.php");
        exit;
    }

    $error = "Invalid username or password.";
}

include "../includes/header.php";
?>

<div class="container mt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow">

                <div class="card-body">

                    <h2 class="mb-4">Administrator Login</h2>

                    <?php if ($error): ?>
                        <div class="alert alert-danger">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">

                        <div class="mb-3">
                            <label>Username</label>

                            <input
                                type="text"
                                name="username"
                                class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label>Password</label>

                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                required>
                        </div>

                        <button class="btn btn-primary w-100">
                            Login
                        </button>

                    </form>

                    <div class="text-center mt-3">
                        <a href="forgot_password.php">
                            Forgot Password?
                        </a>
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?php include "../includes/footer.php"; ?>