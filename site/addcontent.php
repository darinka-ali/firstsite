<link rel="stylesheet" type="text/css" href="mystyle.css">
<?php
  include_once("config.php");
  include_once('iflogged.php');
  if(isset($_POST["submit"])) {
    $teaser = trim(strip_tags($_POST['teaser']));
    $text = trim(strip_tags($_POST['text']));
    addContent($teaser, $text, $_SESSION['login'], time());
    $id = getMax();
    header("Location: content.php?id=$id[0]");
  }
  else {
  ?>
  <html>
   <title>
    Adding content
   </title>
   <body>
    <form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">
       <table>
       <tr><td>Teaser:</td><td><input type="text" name="teaser"  maxlength="150"></td></tr>
       <tr><td>Text:</td><td><textarea id="text" name="text" rows="10" cols="70"></textarea></td></tr>
       <tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Add"></td></tr>
       </table>
    </form>
   </body>
  </html>
  <?php
  }