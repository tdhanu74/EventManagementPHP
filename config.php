<?php
    define("HOSTNAME", "localhost");
    define("USERNAME", "root");
    define("PASSWORD", "diploma");
    define("DBNAME", "event");
    define("PORT", 3306);
    $con = mysqli_connect(HOSTNAME,USERNAME,PASSWORD,DBNAME,PORT) or die ("cannot connect to database.");
    //if($con) echo "You are connected.";
?>