<?php

require_once "../config/auth.php";

include "../includes/header.php";

include "../includes/navbar.php";

?>

<div class="container mt-5">

<div class="card shadow">

<div class="card-body">

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

<a

href="create_post.php"

class="list-group-item">

Create New Post

</a>

<a

href="../index.php"

class="list-group-item">

View Website

</a>

<a

href="../logout.php"

class="list-group-item text-danger">

Logout

</a>

</div>

</div>

</div>

</div>

<?php

include "../includes/footer.php";

?>