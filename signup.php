<?php
require_once 'back-end/Auth.php' ;
require_once 'back-end/DatabaseManager.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try
{
	$db_manager = new DatabaseManager();
	$auth = new Auth();
}
catch (\PDOException $e)
{
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
if (isset($_POST['submit']))
{
  $auth->insert($auth->getForm());
  header( "Location: login.php" );
}

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<link rel="stylesheet" href="css/master.css">
		<meta charset="utf-8">
		<title>Sign up</title>
	</head>
	<body>

		<ul>
		 <li><a href="index.php">Home</a></li>
		 <li><a href="login.php">Log in</a></li>
		 <li><a class="active" href="signup.php">Sign up</a></li>
		 <li><a href="#about">About</a></li>
		</ul>

		<div class="login" align="center">
			<h1>Register</h1>
		    <form method="post">
					<input type="email" placeholder="Email" required="required">
					<br> <br>
		      <input type="password" placeholder="Password" required="required" />
					<br> <br>
		      <button type="submit" class="">Sign up</button>
		    </form>
		</div>
	</body>
</html>
