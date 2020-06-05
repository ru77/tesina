<?php
require_once 'back-end/Auth.php' ;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL | E_WARNING | E_NOTICE);
ini_set('display_errors', TRUE);

try
{
		$auth = new Auth();
}
catch (\PDOException $e)
{
  throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
if (isset($_POST['submit']))
{
	echo "string";
	$form = ['email'=>$_POST["email"],'password' => $_POST['password']];
	echo $form['email'];
  $auth->insert($form);
	flush();
  header("Location:index.php",true,  301 );
	die('should have redirected by now');
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
		    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post">
					<input type="email" name="email" placeholder="Email" required="required">
					<br> <br>
		      <input type="password" name="password" placeholder="Password" required="required" />
					<br> <br>
		      <button type="submit" class="">Sign up</button>
		    </form>
		</div>
	</body>
</html>
