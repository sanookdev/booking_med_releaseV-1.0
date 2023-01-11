<?php

// Content of database.php

$mysqliConn = mysqli_connect('192.168.66.1', 'root', 'medadmin', 'med_booking');
// $mysqliConn = mysqli_connect('localhost', 'root', '', 'booking-med');

if (!$mysqliConn){
    die("Could not connect to database: ".mysqli_connect_error());
}


?>