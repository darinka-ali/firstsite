<?php
  include_once("config.php");
  if(isset($_POST["submit"])) {
    $id = $_GET['id'];
    updContent($id, $_POST["teaser"], $_POST["text"]);
    header("Location: content.php?id=$id");
  }
  else
  { 
    if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
        exit("No id");
      header("Location: content.php");
    }
    $id = $_GET['id'];
    $content = getContent($id);
    $teaser = $content['teaser'];
    $text = $content['text'];
    ?>
    <html>
     <form action="<?php print "editcontent.php?id=" . $id; ?>" method="POST">
        <table>
        <tr><td>Teaser:</td><td><input type="text" name="teaser" value="<?php print $teaser; ?>" maxlength="150"></td></tr>
        <tr><td>Text:</td><td><textarea id="text" name="text"  rows="10" cols="70"><?php print $text; ?></textarea></td></tr>
        <tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Update"></td></tr>
        </table>
        </form>
    </html>
    <?php
}