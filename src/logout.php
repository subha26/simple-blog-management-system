<?php

require_once "includes/session.php";
require_once "config/session.php";

session_destroy();

#header("Location: admin/login.php");
header("Location: index.php");

exit;