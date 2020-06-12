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

		<div class="center_block" align="center">
			<h1>Register</h1>
	    <form id="user_registration">
				<input type="email" name="email" placeholder="Email" required="required">
				<br> <br>
	      <input type="password" name="password" placeholder="Password" required="required" />
				<br> <br>
	      <button>Sign up</button>
	    </form>
			<div id="response"></div>
		</div>
		<script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
		<script>
			var form = document.getElementById("user_registration");
			form.onsubmit = function(event){
				event.preventDefault();
				var email = form.elements.email.value;
				var psw = form.elements.password.value;
				var response = $("#response");
				jQuery.ajax({
					type: "POST",
					url: "back-end/Controller.php",
					data: { registration: true, email: email, password: psw },
					success: function(data){
						response.innerText = data;
						alert("ti sei registrato");
						window.location ='login.php';
					},
					error: function(error){
						response.innerText = data;
					},
				});
			}
		</script>
	</body>
</html>
