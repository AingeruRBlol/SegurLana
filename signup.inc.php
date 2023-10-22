<?php

if (isset($_POST["submit"])){
    
    $erabiltzaile = $_POST["erabiltzaile"];
    $pasahitza = $_POST["pasahitza"]; //va a guardar en name lo que reciba con la etiqueta name 
    $izenAbizena = $_POST["izenAbizena"];
    $nan = $_POST["nan"];
    $telefonoa = $_POST["telefonoa"];
    $email = $_POST["email"];
    $data = $_POST["data"];

    require_once 'dbh.inc.php';
    require_once 'functions.inc.php';

    if (emptyInputSignup($erabiltzaile, $pasahitza, $izenAbizena, $nan, $telefonoa, $email, $data) !== false){
        header("location: ../signup.php?error=emptyinput");
        exit();
    }
    if (uidExists($conn, $erabiltzaile, $email) !== false){
        header("location: ../signup.php?error=usernametaken");
        exit();
    }
    if (invalidName($izenAbizena) !== false){
        header("location: ../signup.php?error=invalidname");
        exit();
    }
    if (invalidUid($erabiltzaile) !== false){
        header("location: ../signup.php?error=invaliduid");
        exit();
    }
    if (invalidNan($nan) !== false){
        header("location: ../signup.php?error=invalidnan");
        exit();
    }
    if (invalidEmail($email) !== false){
        header("location: ../signup.php?error=invalidemail");
        exit();
    }    if (invalidTlfn($telefonoa) !== false){
        header("location: ../signup.php?error=invalidtlfn");
        exit();
    }


    createUser($conn, $erabiltzaile, $pasahitza, $izenAbizena, $nan,  $telefonoa, $email, $data);



}
else{
    header("location: ../signup.php");
}