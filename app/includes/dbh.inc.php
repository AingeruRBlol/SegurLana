<?php

$serverName = "db";
$dBUsername = "root";
$dBPassword = "root";
$dBName = "database";

$conn = mysqli_connect($serverName, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}