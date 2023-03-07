<?php include('config/constants.php'); ?>
<html>
	<head>
		<meta charset="utf-8" />
		<title>Login - Food Order Website</title>
		<link rel="stylesheet" href="../css/login.css" />
	</head>
	<body>
		<div class="center">
			<h1>Login</h1>
			<?php
				if(isset($_SESSION['login']))
                {
                    echo $_SESSION['login'];
                    unset($_SESSION['login']);
                }
				if(isset($_SESSION['no-login-message']))
                {
                    echo $_SESSION['no-login-message'];
                    unset($_SESSION['no-login-message']);
                }
			?>
			<form action="" method="post">
				<div class="txt_field">
					<input type="text" name="username" required />
					<span></span>
					<label>Username</label>
				</div>
				<div class="txt_field">
					<input type="password" name="password" required />
					<span></span>
					<label>Password</label>
				</div>
				<input type="submit" name="submit" value="Login" /> <br /><br />
				<p class="text-center">Created By Kato</p>
			</form>
		</div>
	</body>	
</html>

<?php
	
	if(isset($_POST['submit']))
	{
		//Process Login
		//Get Data from Form
		$username = mysqli_real_escape_string($conn, $_POST['username']);
		$raw_password = md5($_POST['password']);
		$password = mysqli_real_escape_string($conn, $raw_password);

		//SQL check
		$sql = "SELECT * FROM tbl_admin WHERE username='$username' AND password='$password'";

		//Execute
		$res = mysqli_query($conn,$sql);

		$count = mysqli_num_rows($res);

		if($count==1)
		{
			$_SESSION['login'] = "<div class='success'>Login Successful.</div>";
			$_SESSION['user'] = $username; //Check whether user logged in 
			//Redirect
			header('location:'.SITEURL.'admin/');
		}
		else
		{
			$_SESSION['login'] = "<div class='error text-center'>Failed to Login.</div>";
			//Redirect
			header('location:'.SITEURL.'admin/login.php');
		}
	}	

?>
