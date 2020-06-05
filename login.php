<?php
require_once 'back-end/Auth.php' ;
require_once 'back-end/DatabaseManager.php';

if (isset($_POST['submit']))
{

	$auth = new Auth();

	$pdo = $db_manager->getInstance()  ;

	$form = ['username'=>$_POST["username"],'password' => $_POST['password']];

	if ($auth->check($pdo,$form))
	{
			session_start();
			$_SESSION["type"] = "user";
			header( "Location:control_panel.php" );
	}
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<link rel="stylesheet" href="css/master.css">
		<meta charset="utf-8">
		<title>Log in</title>
	</head>
	<body>

		<ul>
		 <li><a href="index.php">Home</a></li>
		 <li><a class="active" href="login.php">Log in</a></li>
		 <li><a href="signup.php">Sign up</a></li>
		 <li><a href="#about">About</a></li>
		</ul>

		<main>
			<div class="login" align="center">
				<h1>Log in</h1>
			    <form method="post">
			    	<input type="email" placeholder="Email" required="required">
						<br> <br>
			      <input type="password" placeholder="Password" required="required" />
						<br> <br>
			      <button type="submit" class="">log in</button>
			    </form>
			</div>
		</main>

	</body>
</html>
