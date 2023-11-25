<?php
session_start();

if (isset($_POST["submit"])){
    $erabiltzaile = $_POST["erabiltzaile"];
    $pasahitza = $_POST["pasahitza"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputLogin($erabiltzaile, $pasahitza) !== false){
        header("location: ../login.php?error=emptyinput");
        exit();
    }

    loginUser($conn, $erabiltzaile, $pasahitza);

    if (maxLogTry($erabiltzaile, 5, $conn)) {
        blockAccount($erabiltzaile, $conn);
        header("location: ../login.php?error=accountlocked");
        exit();
    }

}
else {
    header("location: ../login.php");
    exit();
}