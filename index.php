<?php
require_once 'back-end/DatabaseManager.php';

try
{
  $db_manager = new DatabaseManager();
  $db_manager->writeDB();
}
catch (\PDOException $e)
{
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}


 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/master.css">
    <title>Simple Home Cloud</title>
  </head>
  <body>
    <ul>
     <li><a class="active" href="#home">Home</a></li>
     <li><a href="login.php">Log in</a></li>
     <li><a href="signup.php">Sign up</a></li>
     <li><a href="#about">About</a></li>
    </ul>

    <div class="header">
      <h1 align="center">Simple Home Cloud</h1>
    </div>

    <main>
      <table align="center" cellpadding="50" >
        <tr>
          <td>
            <p > Simple by design  </p>
            <br>
            <p  >Our software follows the <a href="#">kiss</a> philosophy</p>
          </td>
          <td>
            <p > Cryptography  </p>
            <br>
            <p >Your file are stored safely with xxx encryption</p>
          </td>
          <td>
            <p > Installation </p>
            <br>
            <p >  Ready to use setup on your personal devices </p>
          </td>
        </tr>
      </table>
    </main>
    <div class="footer">
    </div>
  </body>
</html>
