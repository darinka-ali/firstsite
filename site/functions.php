<?php

function connectToDB() {
  global $link, $dbhost, $dbuser, $dbpass, $dbname;
  ($link = mysqli_connect("$dbhost", "$dbuser", "$dbpass")) || die("Couldn't connect to MySQL");
  mysqli_select_db($link, "$dbname") || die("Couldn't open db: $dbname. Error if any was: ".mysqli_error($link) );
}



function newUser($login, $password) {
  global $link;

  $query="INSERT INTO users (login, password) VALUES('$login', '$password')";
  $result=mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));

  return true;
}



function displayErrors($messages) {
  print("<b>There are such errors:</b>\n<ul>\n");

  foreach($messages as $msg){
    print("<li>$msg</li>\n");
  }
  print("</ul>\n");
}




function checkLoggedIn($status){
  switch($status){
    case "yes":
      if(!isset($_SESSION["loggedIn"])){
      //  header("Location: index.php");
        //exit;
      }
      break;
    case "no":
      if(isset($_SESSION["loggedIn"]) && $_SESSION["loggedIn"] === true ){
        //  header("Location: index.php");
      }
      break;
  }
  return true;
}



function checkPass($login, $password) {
  global $link;

  $query="SELECT login, password FROM users WHERE login='$login' and password='$password'";
  $result=mysqli_query($link, $query)
    or die("checkPass fatal error: ".mysqli_error($link));
  $init = mysqli_stmt_init($link);
  if($result->num_rows == 1) {
    $row = mysqli_fetch_array($result);
    return $row;
  }
  return false;
}


function cleanMemberSession($login, $password) {
  $_SESSION["login"]=$login;
  $_SESSION["password"]=$password;
  $_SESSION["loggedIn"]=true;
}


function flushMemberSession() {
  unset($_SESSION["login"]);
  unset($_SESSION["password"]);
  unset($_SESSION["loggedIn"]);
  session_destroy();
  return true;
}

function field_validator($field_descr, $field_data, $field_type, $min_length="", $max_length="", $field_required=1) {
  global $messages;
  if(!$field_data && !$field_required){ return; }
  $field_ok=false;
  $email_regexp="^([a-zA-Z0-9_\-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|";
  $email_regexp.="(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)+$";
  $data_types=array(
    "email"=>$email_regexp,
    "digit"=>"^[0-9]$",
    "number"=>"^[0-9]+$",
    "alpha"=>"^[a-zA-Z]+$",
    "alpha_space"=>"^[a-zA-Z ]+$",
    "alphanumeric"=>"/^[a-zA-Z0-9]/",
    "alphanumeric_space"=>"^[a-zA-Z0-9 ]+$",
    "string"=>"^+$"
  );
  if ($field_required && empty($field_data)) {
    $messages[] = "Field $field_descr is required";
    return;
  }
  if ($field_type == "string") {
    $field_ok = true;
  } else {
    $field_ok = preg_match($data_types[$field_type], $field_data);
  }
  if (!$field_ok) {
    $messages[] = "Please enter correct $field_descr.";
    return;
  }
  if ($field_ok && ($min_length > 0)) {
    if (strlen($field_data) < $min_length) {
      $messages[] = "$field_descr must be not shorter $min_length chars.";
      return;
    }
  }
  if ($field_ok && ($max_length > 0)) {
    if (strlen($field_data) > $max_length) {
      $messages[] = "$field_descr must be not longer $max_length chars.";
      return;
    }
  }
}

function getMax() {
  global $link;
  date_default_timezone_set('Europe/Kiev');
  $query="SELECT MAX(`id`) FROM `content`";
  //$result = mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));
  $result = mysqli_query($link, $query) or die("Sorry :( Something wrong is happening now. Try to do it later");
  $id = mysqli_fetch_array($result);
  return $id;
}

function addContent($teaser, $text, $author, $pubdate) {
  global $link;
  $teaser = mysqli_real_escape_string($link, $teaser);
  $text = mysqli_real_escape_string($link, $text);
  $query="INSERT INTO `content` (`teaser`, `text`, `author`, `pubdate`) VALUES('$teaser', '$text', '$author', $pubdate)";
 // $result=mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));
  $result=mysqli_query($link, $query) or die("Sorry :( Something wrong is happening now. Try to do it later");
  if (mysqli_affected_rows($link) == 1) print 'Your record inserted successfully';
  else print 'Something wrong is happening with your record. It do not want to be inserted';
  }
  
function getContent($id) {  
  global $link;
  $id = $id * 1;
  if (is_int($id) && ($id>0)) {
    $query="SELECT `teaser`, `text`, `author`, `pubdate` FROM `content` WHERE `id` = '$id'";
    //$result=mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));
    $result=mysqli_query($link, $query) or die("Sorry :( Something wrong is happening now. Try to do it later");
    if (mysqli_affected_rows($link) == 1) { 
      $content = mysqli_fetch_assoc($result);
      return $content;}
    else {
      print '<br> Please do not type id by yourself!';
      return false;
    }    
  }
  else {
    print "We have no such records in our database!";
    return false;
  }
}

function getAllContent() {  
  global $link;
  $items_per_page = 10;
  $query = "SELECT `id` FROM `content`";
  $do = mysqli_query($link, $query);
  $pages = mysqli_affected_rows($link);
  $pages = ceil($pages/$items_per_page);
  $page = !empty($_GET['page']) ? $_GET['page'] : 1;
  $from = ($page -1) * $items_per_page;
  $query="SELECT `id`, `teaser`, `text`, `author`, `pubdate` FROM `content` LIMIT {$from}, {$items_per_page}";
  //$result=mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));
  $result=mysqli_query($link, $query) or die("Sorry :( Something wrong is happening now. Try to do it later");
  if (!empty($result)) {
    while ($content = mysqli_fetch_assoc($result)) {
      print '<br>' . trim(strip_tags($content['teaser']));
      print '<br>' . trim(strip_tags($content['author']));
      print '<br>' . date('d.m.Y',$content['pubdate']) . '<br>';
      $id = $content['id'];
      $text = trim(strip_tags($content['text']));
      if (mb_strlen($text)>10) {
         print substr($text, 0, 10) . "<a href=\"content.php?id=". $id ."\">...</a><br>";
      }
      else {
        print $text . '<br>';
      }
      print "<a href=\"content.php?id=". $id ."\">Read more</a><br>";
    }
  }
  for ($i = 1; $i<$page; $i++) {
    print "<a href=\"contents.php?page=". $i ."\">".$i. '   ' . "</a>";
  }
  for ($i = $page; $i<=$pages; $i++) {
    print "<a href=\"contents.php?page=". $i ."\">".$i.'   ' . "</a>";
  }
 // return $result;
  return true;
}

function updContent($id, $teaser, $text) {  
  global $link;
  $id = $id*1;
  if (is_int($id) && ($id>0)) {
    $teaser = mysqli_real_escape_string($link, $teaser);
    $text = mysqli_real_escape_string($link, $text);
    $cont = getContent($id);
    if (!empty($cont)) {
      $query="UPDATE `content` SET `teaser`='$teaser', `text`='$text' WHERE `id` = '$id'";
      //$result=mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));
      $result=mysqli_query($link, $query) or die("Sorry :( Something wrong is happening now. Try to do it later");
      if (mysqli_affected_rows($link) == 1) print 'Your record updated successfully';
      else print 'Something wrong is happening with your record. It do not want to be updated';
    }
    else {
      print '<br> Please do not type id by yourself!';
      return false;
    }
  }
  else {
    print "We have no such records in our database!";
    return false;
  }
}

function delContent($id) {
  global $link;
  $id = $id * 1;
  if (is_int($id) && ($id>0)) {
    if (getContent($id)) {
      $query="DELETE FROM `content` WHERE `id` = '$id'";
      //$result=mysqli_query($link, $query) or die("Died inserting login info into db.  Error returned if any: ".mysqli_error($link));
      $result=mysqli_query($link, $query) or die("Sorry :( Something wrong is happening now. Try to do it later");
      return true;
      if (mysqli_affected_rows($link) == 1) print 'Your record deleted successfully';
      else print 'Something wrong is happening with your record. It do not want to be deleted';
      //return print "Your record has been deleted successfully!";
    }
    else {
      print '<br> Please do not type id by yourself!';
      return false;
    }
  }
  else {
    exit("We have no such records in our database!");
  }
}



