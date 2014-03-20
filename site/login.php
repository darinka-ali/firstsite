<?php
include_once("config.php");
checkLoggedIn("no");
$title="Please, login";
if(isset($_POST["submit"])) {
  field_validator("login name", $_POST["login"], "alphanumeric", 4, 15);
  field_validator("password", $_POST["password"], "string", 4, 15);
  if($messages){
    doIndex();
    exit;
  }  
  if( !($row = checkPass($_POST["login"], $_POST["password"])) ) {
      $messages[]="Incorrect login/password, try again";
  }  
  if($messages){
    doIndex();
    exit;
  }  
  cleanMemberSession($row["login"], $row["password"]);  
  header("Location: index.php");
}
else
{
  doIndex();
}

/**
 * Login form.
 */
function doIndex() {
  global $messages;
  global $title;
  include 'login.form.inc';
}
