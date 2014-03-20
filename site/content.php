<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<link rel="stylesheet" type="text/css" href="mystyle.css">
<?php
  include_once("config.php");
  include_once('iflogged.php');
  $id = $_GET['id'];
  if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: contents.php");
  }
  $cont = getContent($id);
  $teaser = trim(strip_tags($cont['teaser']));
  $text = trim(strip_tags($cont['text']));
?>
<title>
  <?php echo $teaser;?>
</title>
<body>
<h1> <?php print $teaser; ?> </h1><br>
<h3> <?php print $text; ?> </h3>
 <?php  print 'Published by ' . trim(strip_tags($cont['author'])) . ' ' . date('d.m.Y',$cont['pubdate']);
  if (isset($_SESSION["loggedIn"])) {
    print('<br><a href="editcontent.php?id='. $id . "\">Edit</a>");
    print('       ' . "<a href=\"deletecontent.php?id=". $id ."\">Delete</a>");
  }
 ?>
</body> 
  