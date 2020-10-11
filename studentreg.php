<?php include "./config.php" ?>
<!-- Page for student registration -->
<!DOCTYPE html>
<html>
	<head>
		<title>Student Registration</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script>
			$(function () {
				$('form').on('submit', function (e) {
					e.preventDefault();
					$.ajax({
						type: 'post',
						url: 'register.php',
						data: $('form').serialize(),
						secure: true,
							headers: {
								'Access-Control-Allow-Origin': '*',
							},
						success: function () {
							alert('You have registered for the Event, check your email for the seats reserved');
						}
					});
				});
			});
		</script>
	</head>
	<body>
		<div id="container"> <!-- Div for filling the whole page -->
			<div id="header"> <!-- Header div for Logo and Page Name -->
				<img src="images/logo.png">
				Student Registration
			</div>
			<div id="center"> <!-- Main div for Storing the form -->
				<div id="bloc"> <!-- Div for creating the white block for the form -->
					<form>
						<label>First Name</label><br>
						<input type="text" name="fname"><br>
						<label>Last Name</label><br>
						<input type="text" name="lname"><br>
						<label>Roll Number</label><br>
						<input type="text" name="roll"><br>
						<label>Department</label><br>
						<select name="dep">
							<option value="CMPN">CMPN</option>
							<option value="IT">IT</option>
							<option value="EXTC">EXTC</option>
							<option value="ETRX">ETRX</option>
							<option value="BIOM">BIOM</option>
						</select><br>
						<label>Email</label><br>
						<input type="email" name="email"><br>
						<label>Contact Number</label><br>
						<input type="tel" name="phone"><br>
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
						<label>Number of People Attending</label><br>
						<select name="parents">
							<option value=1>I am attending</option>
							<option value=2>I am attending with one of my parent</option>
							<option value=3>I am attending with both of my parents</option>
							<option value=4>I am not attending but one of my parent is</option>
							<option value=5>I am not attending but both of my parents are</option>
						</select><br>
						<input type="submit" name="submit" value="Submit"></td>  
					</form>
				</div>
			</div>
			<div id="footer"> <!-- Footer div for About Us information -->
				Abous Us Stuff
			</div>
		</div>
	</body>
</html>