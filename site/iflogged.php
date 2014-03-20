<?php
  include_once("config.php");
  if (!isset($_SESSION["login"])) {
    include_once("login.php");
  }
  include_once("members.php");
  if (($_SERVER['PHP_SELF'] != '/addcontent.php')&&(isset($_SESSION["loggedIn"]))){ 
    print('      ' . "<a href=\"addcontent.php"."\">Add content</a>" . '      ');
  }
  if ($_SERVER['PHP_SELF'] != '/contents.php') {
   print("<a href=\"contents.php"."\">View all content</a><br>");
  }