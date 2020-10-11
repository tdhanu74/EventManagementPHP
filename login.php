<?php include "./config.php" ?>
<!DOCTYPE html>
<!-- Page for Admin Login -->
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="css/style1.css">
	</head>
	<body>
		<div id="container"> <!-- Div for filling the whole page -->
			<div id="header"> <!-- Header div for Logo and Page Name -->
				<img src="images/logo.png">
				Login
			</div>
			<div id="center"> <!-- Main div for Storing the form -->
				<div id="bloc"> <!-- Div for creating the white block for the form -->
					<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="POST">
						<label>Username</label><br>
						<input type="email" name="user"></td><br>
						<label>Password</label></td><br>
						<input type="password" name="pass"></td><br>
						<input name="submit" type="submit" value="Submit">
					</form>
				</div>
			</div>
			<?php
				if((isset($_POST['submit']))){
					$user = $_POST['user'];
					$pass = $_POST['pass'];
					$query = "SELECT * FROM auth WHERE user='$user' AND pass='$pass'"; #Checking if the user exists and password is correct
					$fire = mysqli_query($con,$query) or die("Error in fetching data".mysqli_error($con));
					if ($fire){
						if (mysqli_num_rows($fire) == 1) #If the username and password is correct
						{
							setcookie('user',$user,time() + 86400,"/"); #Setting cookie for user
							header("Location: dashboard.php"); #Redirecting to Dashboard
						}
					}
				}
			?>
			<div id="footer"> <!-- Footer div for About Us information -->
				Abous Us Stuff
			</div>
		</div>
	</body>
</html>