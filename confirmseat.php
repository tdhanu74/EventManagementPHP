<?php include "./config.php" ?>
<?php
	$id = $_POST['student'];
	$parents = $_POST['parents'];
	if ($parents == 1||$parents == 2||$parents == 3){ #Confirming Student Seat
		$query = "UPDATE SEAT SET OCCUPIED='P' WHERE REGISTRATION_ID=$id";
		$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
	}
	if ($parents == 2||$parents == 4){ #Confirming a single parent seat
		$query1 = "UPDATE PARENTS SET OCCUPIED='P' WHERE STUDENT_ID=$id LIMIT 1";
		$fire1 = mysqli_query($con,$query1) or die("cannot insert data into database. ".mysqli_error($con));
	}
	if ($parents == 3||$parents == 5){ #Confirming both parents seat
		$query2 = "UPDATE PARENTS SET OCCUPIED='P' WHERE STUDENT_ID=$id";
		$fire2 = mysqli_query($con,$query2) or die("cannot insert data into database. ".mysqli_error($con));
	}
?>