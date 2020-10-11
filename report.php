<?php include "./config.php" ?>
<?php include "./utility.php" ?>
<?php
	$event = $_POST['event'];
	$table = $_POST['table'];
	$attend = $_POST['attend'];
	$query = "SELECT * FROM EVENTS WHERE ID=$event";
	$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
	$row = mysqli_fetch_assoc($fire);
	$name = $row['NAME']." ".$table." ".$attend.".csv"; #Naming the CSV file download
	if($table == "Student" && $attend == "Present"){ #Creating CSV for Present Students
		$ar[] = ["ID","First Name","Last Name","Seat"];
		$query1 = "SELECT SEAT.REGISTRATION_ID AS ID, REGISTRATION.FNAME AS FNAME, REGISTRATION.LNAME AS LNAME, SEAT.SEAT AS SEAT FROM SEAT INNER JOIN REGISTRATION ON SEAT.REGISTRATION_ID=REGISTRATION.ID AND SEAT.EVENT_ID=$event AND OCCUPIED='P' ORDER BY SEAT";
		$fire1 = mysqli_query($con,$query1) or die("cannot insert data into database. ".mysqli_error($con));
		while($row1 = mysqli_fetch_assoc($fire1)) { #Creating array for Present Students
		   $ar[] = $row1;
		}
		array_to_csv_download($ar,$name);
	}
	else if($table == "Student" && $attend == "Absent"){ #Creating CSV for Absent Students
		$ar[] = ["ID","First Name","Last Name","Seat"];
		$query1 = "SELECT SEAT.REGISTRATION_ID AS ID, REGISTRATION.FNAME AS FNAME, REGISTRATION.LNAME AS LNAME, SEAT.SEAT AS SEAT FROM SEAT INNER JOIN REGISTRATION ON SEAT.REGISTRATION_ID=REGISTRATION.ID AND SEAT.EVENT_ID=$event AND (OCCUPIED='A' OR OCCUPIED='D') ORDER BY SEAT";
		$fire1 = mysqli_query($con,$query1) or die("cannot insert data into database. ".mysqli_error($con));
		while($row1 = mysqli_fetch_assoc($fire1)) { #Creating array for Absent Students
		   $ar[] = $row1;
		}
		array_to_csv_download($ar,$name);
	}
	else if($table == "Parents" && $attend == "Present"){ #Creating CSV for Present Parents
		$ar[] = ["ID","First Name","Last Name","Seat"];
		$query1 = "SELECT PARENTS.STUDENT_ID AS ID, REGISTRATION.FNAME AS FNAME, REGISTRATION.LNAME AS LNAME, PARENTS.SEAT AS SEAT FROM PARENTS INNER JOIN REGISTRATION ON PARENTS.STUDENT_ID=REGISTRATION.ID AND REGISTRATION.EVENT_ID=$event AND PARENTS.OCCUPIED='P' ORDER BY SEAT";
		$fire1 = mysqli_query($con,$query1) or die("cannot insert data into database. ".mysqli_error($con));
		while($row1 = mysqli_fetch_assoc($fire1)) { #Creating array for Present Parents
		   $ar[] = $row1;
		}
		array_to_csv_download($ar,$name);
	}
	else{ #Creating CSV for Absent Parents
		$ar[] = ["ID","First Name","Last Name","Seat"];
		$query1 = "SELECT PARENTS.STUDENT_ID AS ID, REGISTRATION.FNAME AS FNAME, REGISTRATION.LNAME AS LNAME, PARENTS.SEAT AS SEAT FROM PARENTS INNER JOIN REGISTRATION ON PARENTS.STUDENT_ID=REGISTRATION.ID AND REGISTRATION.EVENT_ID=$event AND (PARENTS.OCCUPIED='A' OR OCCUPIED='D') ORDER BY SEAT";
		$fire1 = mysqli_query($con,$query1) or die("cannot insert data into database. ".mysqli_error($con));
		while($row1 = mysqli_fetch_assoc($fire1)) { #Creating array for Absent Parents
		   $ar[] = $row1;
		}
		array_to_csv_download($ar,$name);
	}
?>