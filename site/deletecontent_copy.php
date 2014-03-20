<?php
  include_once("config.php");
   if(isset($_POST["submit"])) {    
    $id = $_GET['id'];
    delContent($id);
    header("Location: contents.php");
  }
  else
  {
  if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: content.php");
  } 
  $id = $_GET['id'];
 // $content = getContent($id);
?>
<html>
 <form action="<?php print $_SERVER["PHP_SELF"] . "?id=$id"; ?>" method="POST">
    <table>
    <tr><td>Do you really want to delete this content?</td></tr>
    <tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Delete"></td></tr>
    </table>
    </form>
</html>
<?php
  }