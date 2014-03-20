<html>
  <head>
    <title><?php print $title; ?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  </head>
  <body>
    <h1><?php print $title; ?></h1>
      <?php
        if ($messages) { displayErrors($messages); }
      ?>
    <form action="<?php print $_SERVER["PHP_SELF"]; ?>" method="POST">
      <table>
        <tr>
          <td>Login:</td>
          <td>
            <input type="text" name="login" value="<?php print isset($_POST["login"]) ? $_POST["login"] : "" ; ?>"maxlength="15">
          </td>
        </tr>
        <tr>
          <td>Password:</td>
          <td>
            <input type="password" name="password" value="" maxlength="15">
          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="submit" type="submit" value="Submit"></td>
        </tr>
      </table>
    </form>
  </body>
</html>