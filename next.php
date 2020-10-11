<?php include "./config.php" ?>
<!DOCTYPE html>
<!-- Page for Event Selection of Confirm Seat -->
<html>
	<head>
		<title>Seat Confirmation</title>
		<link rel="stylesheet" type="text/css" href="css/style1.css">
	</head>
	<body>
		<?php
			if(isset($_COOKIE['user'])){ #Checking if the user is logged in
				if ($_COOKIE['user'] != ""){ #Checking if the user is empty
					$user = $_COOKIE['user'];
				}
				else{
					header("Location: login.php");
				}
			}
			else{
				header("Location: login.php");
			}
		?>
		<div id="container"> <!-- Div for filling the whole page -->
			<div id="header"> <!-- Header div for Logo and Page Name -->
				<img src="images/logo.png">
				Confirm Seat
			</div>
			<div id="center"> <!-- Main div for Storing the form -->
				<div id="bloc"> <!-- Div for creating the white block for the form -->
					<form method="POST" action="confirm.php">
						<label>Event</label><br>
						<select name="event">
							<?php
								$query = "SELECT * FROM EVENTS WHERE EVENT_DATE >= NOW()";
								$fire = mysqli_query($con,$query) or die("cannot fetch data.".mysqli_error($con));
								while ($row = mysqli_fetch_assoc($fire))
								{
									echo "<option value=".$row['ID'].">".$row['NAME']."</option>";
								}
							?>
						</select><br>
						<input type="submit" name="submit" value="Submit">  
					</form>
				</div>
			</div>
			<div id="footer"> <!-- Footer div for About Us information -->
				Abous Us Stuff
			</div>
		</div>
	</body>
</html>