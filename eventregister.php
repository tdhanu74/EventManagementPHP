<?php include "./config.php" ?>
<?php include "./utility.php" ?>
<?php
	$name = $_POST['name'];
	$date = $_POST['date']." ".$_POST['time'];
	$dep = $_POST['dep'];
	$dep1 = $_POST['dep1'];
	$dep2 = $_POST['dep2'];
	$dep3 = $_POST['dep3'];
	$query = "INSERT INTO EVENTS(NAME,EVENT_DATE,DEP,DEP1_SEAT,DEP2_SEAT,DEP3_SEAT) VALUES('$name','$date','$dep','$dep1','$dep2','$dep3')";
	$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
?>