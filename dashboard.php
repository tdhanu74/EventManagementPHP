<?php include "./config.php" ?>
<!DOCTYPE html>
<!-- Page for Admin Dashboard and recent registration -->
<html>
	<head>
		<title>Dashboard</title>
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
				Dashboard
			</div>
			<div id="center1"> <!-- Main div for Storing the dashboard with less padding -->
				<table cellpadding=25 id="fill">
					<tr>
						<td rowspan=2>
							<div id="bloc2"> <!-- Div for Storing the Navigation Links -->
								<table id="nav">
									<tr>
										<td id="navcell"><a href="eventreg.php">Event Registration</a></td>
									</tr>
									<tr>
										<td id="navcell"><a href="next.php"">Confirm Registration</a></td>
									</tr>
									<tr>
										<td id="navcell"><a href="reportform.php">Report Generation</a></td>
									</tr>
									<tr>
										<td id="navcell"><a href="onspotreg.php">Onspot Registration</a></td>
									</tr>
								</table>
							</div>
						</td>
						<td>
							<div id="bloc1"> <!-- Div for creating the white block for the recent registration for Students -->
								<label>Live Student Seat Allocation</label><br>
								<table id="dash"> <!-- Table for Recent Student Registration -->
									<thead>
										<tr>
											<td>Roll Number</td>
											<td>First Name</td>
											<td>Last Name</td>
											<td>Event</td>
											<td>Seat Allocated</td>
										</tr>
									</thead>
									<tbody>
										<?php
											$query = "SELECT REGISTRATION.ROLL AS ROLL_NUMBER, REGISTRATION.FNAME AS FIRST_NAME,REGISTRATION.LNAME AS LAST_NAME, EVENTS.NAME AS EVENT_NAME, SEAT.SEAT AS SEAT_ALLOCATED FROM SEAT INNER JOIN REGISTRATION ON SEAT.REGISTRATION_ID = REGISTRATION.ID INNER JOIN EVENTS ON SEAT.EVENT_ID = EVENTS.ID ORDER BY SEAT.TIME_REGISTERED DESC LIMIT 10";
											$fire = mysqli_query($con,$query) or die("cannot fetch data.".mysqli_error($con));
											while ($row = mysqli_fetch_assoc($fire))
											{
										?>
										<tr>
											<td><?php echo $row['ROLL_NUMBER']; ?></td>
											<td><?php echo $row['FIRST_NAME']; ?></td>
											<td><?php echo $row['LAST_NAME']; ?></td>
											<td><?php echo $row['EVENT_NAME']; ?></td>
											<td><?php echo $row['SEAT_ALLOCATED']; ?></td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
					<tr>
						<td>
							<div id="bloc1"> <!-- Div for creating the white block for the recent registration for Parents -->
								<label>Live Parent Seat Allocation</label><br>								
								<table id="dash"> <!-- Table for Recent Parents Registration -->
									<thead>
										<tr>
											<td>Roll Number</td>
											<td>First Name</td>
											<td>Last Name</td>
											<td>Event</td>
											<td>Seat Allocated</td>
										</tr>
									</thead>
									<tbody>
										<?php
											$query = "SELECT REGISTRATION.ROLL AS ROLL_NUMBER, REGISTRATION.FNAME AS FIRST_NAME,REGISTRATION.LNAME AS LAST_NAME, EVENTS.NAME AS EVENT_NAME, PARENTS.SEAT AS SEAT_ALLOCATED FROM PARENTS INNER JOIN REGISTRATION ON PARENTS.STUDENT_ID = REGISTRATION.ID INNER JOIN EVENTS ON REGISTRATION.EVENT_ID = EVENTS.ID ORDER BY PARENTS.TIME_REGISTERED DESC LIMIT 10";
											$fire = mysqli_query($con,$query) or die("cannot fetch data.".mysqli_error($con));
											while ($row = mysqli_fetch_assoc($fire))
											{
										?>
										<tr>
											<td><?php echo $row['ROLL_NUMBER']; ?></td>
											<td><?php echo $row['FIRST_NAME']; ?></td>
											<td><?php echo $row['LAST_NAME']; ?></td>
											<td><?php echo $row['EVENT_NAME']; ?></td>
											<td><?php echo $row['SEAT_ALLOCATED']; ?></td>
										</tr>
										<?php
											}
										?>
									</tbody>
								</table>
							</div>
						</td>
					</tr>
				</table>
			</div>
			<div id="footer"> <!-- Footer div for About Us information -->
				Abous Us Stuff
			</div>
		</div>
	</body>
</html>