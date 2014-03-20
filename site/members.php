<?php
  include_once("config.php");
  include_once('iflogged.php');
  checkLoggedIn("yes");
  //print("<b> Wellcome, " . $_SESSION["login"] . "</b>!<br>\n");
  //print("<a href=\"logout.php"."\">Exit</a>");
  $message = "Welcome, anonymous!";
  if (!empty($_SESSION["login"])) {
    $path = $_SERVER["PHP_SELF"];
    $message = "<b> Wellcome, {$_SESSION['login']} </b>!  <a href=\"logout.php?path={$path}"."\">Exit</a>";
  }
  print $message;
