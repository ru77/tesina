<?php
  session_start();
  if(!isset($_SESSION["user_id"])) {
  header("location:login.php");
  die();
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/master.css">
    <title>Home</title>
  </head>
  <body>
    <ul>
     <li><a href="index.php">Home</a></li>
     <li><a class="active" href="control_panel.php">Control Panel</a></li>
     <li><a href="logout.php">Log out</a></li>
    </ul>
    <div class="center_block">
      <form method="POST" action="back-end/Controller.php" enctype="multipart/form-data">
        <div>
          <span>Upload a File:</span>
          <input type="file" name="uploadedFile" />
        </div>
        <br>
        <input type="submit" name="uploadBtn" value="Upload" />
      </form>      <br>
    </div>
    <div class="center_block">
      <div class="">
        <?php
          $thelist = null;
          if ($handle = opendir('back-end/uploaded_files')) {
            while (false !== ($file = readdir($handle))){
              if ($file != "." && $file != ".."){
          	     $thelist .= '<a href="back-end/uploaded_files/'.$file.'">'.$file.'</a> <br>';
               }
          }
          closedir($handle);
        }
        ?>
        <P>List of files:</p>
        <P><?=$thelist?></p>
      </div>



  </body>
</html>
