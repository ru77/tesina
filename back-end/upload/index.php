<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title>PHP File Upload</title>
  <style media="screen">
  .upload{
    border-style: solid;
    padding: 10px;
    text-align: center;
    display: table;
    margin-right: auto;
    margin-left: auto;
    margin-top: 10%;
  }

  </style>
</head>
<body>
  <?php
    if (isset($_SESSION['message']) && $_SESSION['message'])
    {
      printf('<b>%s</b>', $_SESSION['message']);
      unset($_SESSION['message']);
    }
  ?>
  <div class="upload">
    <form method="POST" action="upload.php" enctype="multipart/form-data">
      <div>
        <span>Upload a File:</span>
        <input type="file" name="uploadedFile" />
      </div>
      <br>
      <input type="submit" name="uploadBtn" value="Upload" />
    </form>
  </div>

</body>
</html>
