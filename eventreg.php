<!DOCTYPE html>
<!-- Page for event registration -->
<html>
	<head>
		<title>Event Creation</title>
		<link rel="stylesheet" type="text/css" href="css/style.css">
		<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
		<script>
			$(function () {
				$('form').on('submit', function (e) {
					e.preventDefault();
					$.ajax({
						type: 'post',
						url: 'eventregister.php',
						data: $('form').serialize(),
						secure: true,
							headers: {
								'Access-Control-Allow-Origin': '*',
							},
						success: function () {
							alert('Event has been registered');
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
				Event Registration
			</div>
			<div id="center"> <!-- Main div for Storing the form -->
				<div id="bloc"> <!-- Div for creating the white block for the form -->
					<form>
						<label>Event Name</label><br>
						<input type="text" name="name"><br>
						<label>Event Date and Time</label><br>
						<input type="date" name="date"><input type="time" name="time"><br>
						<label>Departments</label><br>
						<input type="text" name="dep"><br>
						<label>Department Seats 1</label><br>
						<input type="text" name="dep1"><br>
						<label>Department Seats 2</label><br>
						<input type="text" name="dep2"><br>
						<label>Department Seats 3</label><br>
						<input type="text" name="dep3"><br>
						<input type="submit" name="submit" value="Submit"><br>  
					</form>
				</div>
			</div>
			<div id="footer"> <!-- Footer div for About Us information -->
				Abous Us Stuff
			</div>
		</div>
	</body>
</html>