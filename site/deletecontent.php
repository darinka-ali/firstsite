<link rel="stylesheet" type="text/css" href="mystyle.css">
<?php
  include_once("config.php");
  include_once('iflogged.php');
  if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: content.php");
  }
  else {
    $id = $_GET['id'];
    if(isset($_POST["submit"])) {  
      delContent($id);
      header("Location: contents.php");
    }
    else {
      ?>
      <html>
        <title>
          Deleting record
        </title>
        <form action="<?php print "deletecontent.php?id=" . $id; ?>" method="POST">
           <table>
           <tr><td>Do you really want to delete this content?</td></tr>
           <tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Delete"></td></tr>
           </table>
        </form>
      </html>
      <?php
    }
  }