<?php
	function getvalue($text){ #For converting RowNo to Starting seat number in the ro{
		$x = ord($text) - 65;
		if ($x>=9 && $x<15) {
			return (152+(($x-9)*10));
		}
		else if ($x>=15) {
			return (212+(($x-15)*17));
		}
		else{
			return (($x*17)-1);
		}
	}
	function seatLimit($text) { #For converting Seat to its equivalent Seat number
		if ($text == ""){
			return -1;
		}
		$myArray = preg_split("/(,?\s+)|((?<=[a-z])(?=\d))|((?<=\d)(?=[a-z]))/i", $text);
		return (int)$myArray[1] + (int)getvalue($myArray[0]);
	}
	function assignSeat($seat) #For converting Seat number to its equivalent Seat
	{
        if ($seat>152 && $seat<213) {
            $seatno = ($seat - 153)%10 + 1;
            $rowno = floor(($seat-153)/10) + 10;
        }
        else if ($seat>=213) {
            $seatno = ($seat - 213)%17 + 1;
            $rowno = floor(($seat - 213)/17) + 16;
        }
        else{
            $seatno = ($seat)%17 + 1;
            $rowno = floor(($seat)/17) + 1;
        }
		return (chr($rowno+64).$seatno);
	}
	function array_to_csv_download($array, $filename = "export.csv", $delimiter=",") { #For converting the given array to csv and send it as download
		header('Content-Type: application/csv');
		header('Content-Disposition: attachment; filename="'.$filename.'";');
		$f = fopen('php://output', 'w');
		foreach ($array as $line) {
			fputcsv($f, $line, $delimiter);
		}
	}
	function sendmail($email,$seats,$event,$time){ #For sending mail to the student about the seats reserved
		$headers = "MIME-Version: 1.0" . "\r\n"; 
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		$msg = "
			<html>
				<body>
					<h1>Thank you for registering in $event</h3>
					<h2>These are your reserved Seats</h5>
					<h2>
						<table>
							$seats
						</table>
					</h2>
					<h2>Event Date and Time: $time</h2>
					<h2>Reach the Auditorium 30 minutes before the Event time to confirm your seats</h2>
				</body>
			</html>
		";
		mail($email,"Your Reserved Seats for $event",$msg,$headers);
	}
?>