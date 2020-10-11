<?php include "./config.php" ?>
<!DOCTYPE html>
<!-- Page for Report Generation of Event -->
<html>
	<head>
		<title>Report Generation</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
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
					<form method="POST" action="report.php">
						<label>Event</label><br>
						<select name="event">
							<?php
								$query = "SELECT * FROM EVENTS";
								$fire = mysqli_query($con,$query) or die("cannot fetch data.".mysqli_error($con));
								while ($row = mysqli_fetch_assoc($fire))
								{
									echo "<option value=".$row['ID'].">".$row['NAME']."</option>";
								}
							?>
						</select><br>
						<label>People Attending</label><br>
						<select name="table">
							<option value="Student">Student</option>
							<option value="Parents">Parents</option>
						</select><br>
						<label>Attendance</label><br>
						<select name="attend">
							<option value="Present">Present</option>
							<option value="Absent">Absent</option>
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