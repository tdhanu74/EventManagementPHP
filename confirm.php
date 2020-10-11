<?php include "./config.php" ?>
<!DOCTYPE html>
<!-- Page for Confirming Seat -->
<html>
	<head>
		<title>Seat Confirmation</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script>
			$(function () {
				$('form').on('submit', function (e) {
					e.preventDefault();
					$.ajax({
						type: 'post',
						url: 'confirmseat.php',
						data: $('form').serialize(),
						secure: true,
							headers: {
								'Access-Control-Allow-Origin': '*',
							},
						success: function () {
							alert('Seat confirmed');
						}
					});
				});
			});
		</script>
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
					<form>
						<label>Student</label><br>
						<select name="student">
							<?php
								$event = $_POST['event'];
								$query = "SELECT * FROM REGISTRATION WHERE EVENT_ID = $event ORDER BY ROLL";
								$fire = mysqli_query($con,$query) or die("cannot fetch data.".mysqli_error($con));
								while ($row = mysqli_fetch_assoc($fire))
								{
									echo "<option value=".$row['ID'].">".$row['ROLL']." ".$row['NAME']."</option>";
								}
							?>
						</select><br>
						<label>Number of people attending</label><br>
						<select name="parents">
							<option value=1>I am attending</option>
							<option value=2>I am attending with one of my parent</option>
							<option value=3>I am attending with both of my parents</option>
							<option value=4>I am not attending but one of my parent is</option>
							<option value=5>I am not attending but both of my parents are</option>
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