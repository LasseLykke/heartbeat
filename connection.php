<?php

$sname = "localhost";
$uname = "root";
$password = "root";

$db_name = "heartbeat";

$conn = mysqli_connect($sname, $uname, $password, $db_name);
$mysqli = new mysqli("localhost", "root", "root", "heartbeat");

if (!$conn) {
    echo "Connection failed!" . mysqli_connect_error();
}

/* TEST*/