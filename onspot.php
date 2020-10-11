<?php include "./config.php" ?>
<?php include "./utility.php" ?>
<?php
	$fname = $_POST['fname'];
	$lname = $_POST['lname'];
	$roll = $_POST['roll'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$dep = $_POST['dep'];
	$event = $_POST['event'];
	$parents = $_POST['parents'];
	$query = "SELECT * FROM REGISTRATION WHERE ROLL='$roll' AND EVENT_ID=$event";
	$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
	if (mysqli_num_rows($fire)>0){ #Checking if the entry already exists for updation
		$row = mysqli_fetch_array($fire);
		$id = isset($row['ID'])?$row['ID']:0;
		$query1 = "UPDATE REGISTRATION SET ROLL='$roll',FNAME='$fname',LNAME='$lname',DEPT='$dep',EMAIL='$email',MOBILE=$phone,NOPARENTS=$parents WHERE ID=$id";
		$fire1 = mysqli_query($con,$query1) or die("cannot update data. ".mysqli_error($con));
	}
	else{ #Inserting entry if it does not exist
		$query2 = "INSERT INTO REGISTRATION(ROLL,FNAME,LNAME,DEPT,EMAIL,MOBILE,NOPARENTS,EVENT_ID) VALUES('$roll','$fname','$lname','$dep','$email','$phone',$parents,$event)";
		$fire2 = mysqli_query($con,$query2) or die("cannot insert data into database. ".mysqli_error($con));
		$query3 = "SELECT * FROM EVENTS WHERE ID=$event";
		$fire3 = mysqli_query($con,$query3) or die("cannot fetch data from database. ".mysqli_error($con));
		$row3 = mysqli_fetch_array($fire3);
		$dep1 = explode(",",$row3['DEP'])[0]?explode(",",$row3['DEP'])[0]:""; #Getting Department 1 of the event
		$dep2 = explode(",",$row3['DEP'])[1]?explode(",",$row3['DEP'])[1]:""; #Getting Department 2 of the event
		$dep3 = isset(explode(",",$row3['DEP'])[2])?explode(",",$row3['DEP'])[2]:""; #Getting Department 3 of the event
		$dep1_start = seatLimit(explode("-",$row3['DEP1_SEAT'])[0]); #Calculating Seat start of Department 1
		$dep1_end = seatLimit(explode("-",$row3['DEP1_SEAT'])[1]); #Calculating Seat end of Department 1
		$dep2_start = seatLimit(explode("-",$row3['DEP2_SEAT'])[0]); #Calculating Seat start of Department 2
		$dep2_end = seatLimit(explode("-",$row3['DEP2_SEAT'])[1]); #Calculating Seat end of Department 2
		$dep3_start = seatLimit(explode("-",$row3['DEP3_SEAT'])[0]); #Calculating Seat start of Department 3
		$dep3_end = seatLimit(explode("-",$row3['DEP3_SEAT'])[1]); #Calculating Seat end of Department 3
		$parent_start = $dep3_end==-1?$dep2_end+1:$dep3_end+1;  #Calculating Seat start of Parents
		$parent_end = 264; #Seat end of Parents
		$curdate = date("Y-m-d H:i:s");
		switch($dep){ #setting department end with respect to department of the student
			case $dep1: $dep_end = $dep1_end;
				break;
			case $dep2: $dep_end = $dep2_end;
				break;
			case $dep3: $dep_end = $dep3_dep;
				break;
		}
		if($parents == 1||$parents == 2||$parents == 3){ #Checking if the student is visiting
			$query10 = "SELECT * FROM SEAT WHERE OCCUPIED='A' AND REGISTRATION_ID IN (SELECT ID FROM REGISTRATION WHERE DEPT='$dep' AND EVENT_ID=$event) ORDER BY SEAT LIMIT 1";  #Getting the unreserved Seat for Student in his Department
			$fire10 = mysqli_query($con,$query10) or die("cannot fetch data into database. ".mysqli_error($con));
			if(mysqli_num_rows($fire10) > 0){ #If unreserved seat exists
				$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
				$row = mysqli_fetch_array($fire);
				$row10 = mysqli_fetch_array($fire10);
				$id = $row10['REGISTRATION_ID'];
				$id1 = $row['ID'];
				$seatno = $row10['SEAT_NO'];
				$seat = assignSeat($seatno);
				$query5 = "INSERT INTO SEAT(REGISTRATION_ID,EVENT_ID,SEAT_NO,SEAT,TIME_REGISTERED,OCCUPIED) VALUES($id1,$event,$seatno,'$seat','$curdate','P')";
				$fire5 = mysqli_query($con,$query5) or die("cannot insert data into database. ".mysqli_error($con));
				$query11 = "UPDATE SEAT SET OCCUPIED='D' WHERE REGISTRATION_ID=$id AND EVENT_ID=$event";
				$fire11 = mysqli_query($con,$query11) or die("cannot insert data into database. ".mysqli_error($con));
			}
			else{ #If unreserved seat does not exists
				$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
				$row = mysqli_fetch_array($fire);
				$id = $row['ID'];
				$query4 = "SELECT * FROM SEAT WHERE REGISTRATION_ID IN (SELECT ID FROM REGISTRATION WHERE DEPT='$dep' AND EVENT_ID=$event) ORDER BY TIME_REGISTERED DESC LIMIT 1"; #Getting the last allocated Seat for Student in his Department
				$fire4 = mysqli_query($con,$query4) or die("cannot insert data into database. ".mysqli_error($con));
				$row4 = mysqli_fetch_array($fire4);
				if (mysqli_num_rows($fire4) > 0){ #If there is last allocated seat
					if ($row4['SEAT_NO'] + 1 <= $dep_end){
						$seatno = $row4['SEAT_NO'] + 1;
					}
				}
				else{ #If it is the first entry in Department of the Student
					switch($dep){
						case $dep1: $seatno = $dep1_start;
							break;
						case $dep2: $seatno = $dep2_start;
							break;
						case $dep3: $seatno = $dep3_start;
							break;
					}
				}
				$seat = assignSeat($seatno);
				$query5 = "INSERT INTO SEAT(REGISTRATION_ID,EVENT_ID,SEAT_NO,SEAT,TIME_REGISTERED,OCCUPIED) VALUES($id,$event,$seatno,'$seat','$curdate','P')";
				$fire5 = mysqli_query($con,$query5) or die("cannot insert data into database. ".mysqli_error($con));
			}
		}
		if($parents == 2||$parents == 4){ #Checking if a single parent is visiting 
			$query10 = "SELECT * FROM PARENTS WHERE OCCUPIED='A' AND STUDENT_ID IN (SELECT ID FROM REGISTRATION WHERE EVENT_ID=$event) ORDER BY SEAT LIMIT 1"; #Getting the unreserved Seat for Parents
			$fire10 = mysqli_query($con,$query10) or die("cannot fetch data into database. ".mysqli_error($con));
			if(mysqli_num_rows($fire10) > 0){ #If unreserved seat exists
				$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
				$row = mysqli_fetch_array($fire);
				$row10 = mysqli_fetch_array($fire10);
				$id = $row10['STUDENT_ID'];
				$id1 = $row['ID'];
				$seatno = $row10['SEAT_NO'];
				$seat = assignSeat($seatno);
				$query5 = "INSERT INTO PARENTS(SEAT_NO,SEAT,STUDENT_ID,TIME_REGISTERED,OCCUPIED) VALUES($seatno,'$seat',$id1,'$curdate','P')";
				$fire5 = mysqli_query($con,$query5) or die("cannot insert data into database. ".mysqli_error($con));
				$query11 = "UPDATE PARENTS SET OCCUPIED='D' WHERE ID=$id LIMIT 1";
				$fire11 = mysqli_query($con,$query11) or die("cannot insert data into database. ".mysqli_error($con));
			}
			else{ #If unreserved seat does not exists
				$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
				$row = mysqli_fetch_array($fire);
				$id = $row['ID'];
				$query4 = "SELECT * FROM PARENTS WHERE STUDENT_ID IN (SELECT ID FROM REGISTRATION WHERE DEPT='$dep' AND EVENT_ID=$event) ORDER BY TIME_REGISTERED DESC, SEAT DESC LIMIT 1";
				$fire4 = mysqli_query($con,$query4) or die("cannot insert data into database. ".mysqli_error($con));
				if (mysqli_num_rows($fire4) > 0){ #If there is last allocated seat
					$row4 = mysqli_fetch_array($fire4);
					if ($row4['SEAT_NO'] + 1 <= $parent_end){
						$seatno = $row4['SEAT_NO'] + 1;
					}
				}
				else{ #If it is the first entry in Parents
					$seatno = $parent_start;
				}
				$seat = assignSeat($seatno);
				$query6 = "INSERT INTO PARENTS(SEAT_NO,SEAT,STUDENT_ID,TIME_REGISTERED) VALUES($seatno,'$seat',$id,'$curdate')";
				$fire6 = mysqli_query($con,$query6) or die("cannot insert data into database. ".mysqli_error($con));
			}
		}
		if($parents == 3||$parents == 5){ #Checking if a both parent are visiting 
			$count = 0;
			back:$query10 = "SELECT * FROM PARENTS WHERE OCCUPIED='A' AND STUDENT_ID IN (SELECT ID FROM REGISTRATION WHERE EVENT_ID=$event) ORDER BY SEAT LIMIT 1"; #Getting the unreserved Seat for Parents
			$fire10 = mysqli_query($con,$query10) or die("cannot fetch data into database. ".mysqli_error($con));
			if(mysqli_num_rows($fire10) > 0){ #If unreserved seat exists
				$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
				$row = mysqli_fetch_array($fire);
				$row10 = mysqli_fetch_array($fire10);
				$id = $row10['STUDENT_ID'];
				$id1 = $row['ID'];
				$seatno = $row10['SEAT_NO'];
				$seat = assignSeat($seatno);
				$query5 = "INSERT INTO PARENTS(SEAT_NO,SEAT,STUDENT_ID,TIME_REGISTERED,OCCUPIED) VALUES($seatno,'$seat',$id1,'$curdate','P')";
				$fire5 = mysqli_query($con,$query5) or die("cannot insert data into database. ".mysqli_error($con));
				$query11 = "UPDATE PARENTS SET OCCUPIED='D' WHERE ID=$id LIMIT 1";
				$fire11 = mysqli_query($con,$query11) or die("cannot insert data into database. ".mysqli_error($con));
				$count++;
			}
			else{ #If unreserved seat does not exists
				$fire = mysqli_query($con,$query) or die("cannot insert data into database. ".mysqli_error($con));
				$row = mysqli_fetch_array($fire);
				$id = $row['ID'];
				$query4 = "SELECT * FROM PARENTS WHERE STUDENT_ID IN (SELECT ID FROM REGISTRATION WHERE DEPT='$dep' AND EVENT_ID=$event) ORDER BY TIME_REGISTERED DESC, SEAT DESC LIMIT 1";
				$fire4 = mysqli_query($con,$query4) or die("cannot insert data into database. ".mysqli_error($con));
				if (mysqli_num_rows($fire4) > 0){ #If there is last allocated seat
					$row4 = mysqli_fetch_array($fire4);
					if ($row4['SEAT_NO'] + 1 <= $parent_end){
						$seatno = $row4['SEAT_NO'] + 1;
					}
				}
				else{ #If it is the first entry in Parents
					$seatno = $parent_start;
				}
				$seat = assignSeat($seatno);
				$query6 = "INSERT INTO PARENTS(SEAT_NO,SEAT,STUDENT_ID,TIME_REGISTERED) VALUES($seatno,'$seat',$id,'$curdate')";
				$fire6 = mysqli_query($con,$query6) or die("cannot insert data into database. ".mysqli_error($con));
				$count++;
			}
			if($count==1){
				goto back;
			}
		}
	}
?>