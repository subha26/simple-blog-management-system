<?php

require_once "config/session.php";

session_destroy();

header("Location: admin/login.php");

exit;