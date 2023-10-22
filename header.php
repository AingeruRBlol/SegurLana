<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8">
    <title>PHP Project 01</title>
</head>
<body>
<nav>
    <div class="wrapper">
        <ul>
            <li><a href="index.php">Hasiera</a></li>
            <li><a href="zapatilak.php">Zapatilak</a></li>
            <?php
            if (isset($_SESSION["erabiltzaile"])) {
                echo "<li><a href='profile.php'>Profile page</a></li>";
                echo "<li><a href='includes/logout.inc.php'>Log out</a></li>";
            } else {
                echo "<li><a href='signup.php'>Sign Up</a></li>";
                echo "<li><a href='login.php'>Log in</a></li>";
            }
            ?>
        </ul>
    </div>
</nav>
<div class="wrapper">
