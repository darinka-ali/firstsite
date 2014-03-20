<?php
include_once("config.php");
checkLoggedIn("yes");
flushMemberSession();
//header("Location: index.php");
$path = $_GET["path"];
header("Location: $path");
