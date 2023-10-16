<?php

function emptyInputSignup($erabiltzaile, $pasahitza, $izenAbizena, $nan, $telefonoa, $email, $data){
    $result = null;
    if (empty($erabiltzaile) || empty($pasahitza) || empty($izenAbizena) || empty($nan) || empty($telefonoa) || empty($email) || empty($data)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}


function invalidUid($erabiltzaile){
    $result = null;
    if (!preg_match("/^[a-zA-Z0-9]*$/", $erabiltzaile)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidName($name) {
    // Utilizamos una expresión regular para verificar si la cadena contiene solo letras (mayúsculas y minúsculas) y espacios
    return !preg_match("/^[A-Za-z ]+$/", $name);
}


function invalidNan($nan){
    $result = null;
    if (!preg_match("/^\d{8}[A-Z]$/", $nan)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidEmail($email){
    $result = null;
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function invalidDate($date, $format = 'Y-m-d') {
    $result = null;
    $dateTime = DateTime::createFromFormat($format, $date);
    if ($dateTime && $dateTime->format($format) === $date) {
        $result = false;
    } else {
        $result = true;
    }
    return $result;
}

function invalidTlfn($telefonoa){
    // Utilizamos una expresión regular para validar el número de teléfono en formato español (9 dígitos)
    $pattern = "/^[679][0-9]{8}$/";
    
    // Comparamos el número de teléfono con la expresión regular
    if (preg_match($pattern, $telefonoa)) {
        // El número de teléfono es válido
        return false;
    } else {
        // El número de teléfono no es válido
        return true;
    }
}

function pwdMatch($pwd, $pwdRepeat){
    $result = null;
    if ($pwd !== $pwdRepeat){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function uidExists($conn, $erabiltzaile, $email){
    $sql = "SELECT * FROM erabiltzaileak WHERE erabiltzaile = ? OR erabiltzaileEmail = ?;";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        die("Error en la consulta: " . mysqli_error($conn)); // Agregado para depuración
    }

    mysqli_stmt_bind_param($stmt, "ss", $erabiltzaile, $email);
    mysqli_stmt_execute($stmt);

    $resultData = mysqli_stmt_get_result($stmt);

    if($row = mysqli_fetch_assoc($resultData)){
        // Agregado para depuración: Imprime el resultado
        //print_r($row);
        return $row;
    }
    else {
        return false;
    }

    mysqli_stmt_close($stmt);
}


function createUser($conn, $erabiltzaile, $pasahitza, $izenAbizena, $nan,  $telefonoa, $email, $data){
    $sql = "INSERT INTO erabiltzaileak (erabiltzaileIzena, erabiltzaileNAN, erabiltzaileTlfn, erabiltzaileJaiotzedata, erabiltzaileEmail, erabiltzailePasahitza, erabiltzaile) VALUES (?, ?, ?, ?, ?, ?, ?);";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../signup.php?error=stmfailed");
        exit();
    }

    $hashedPas = password_hash($pasahitza, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sssssss",$izenAbizena, $nan, $telefonoa, $data, $email, $hashedPas, $erabiltzaile);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
    header("location: ../signup.php?error=none");
    exit();

}

function emptyInputLogin($erabiltzaile, $pasahitza){
    $result = null;
    if (empty($erabiltzaile) || empty($pasahitza)){
        $result = true;
    }
    else{
        $result = false;
    }
    return $result;
}

function loginUser($conn, $erabiltzaile, $pasahitza) {
    // Verificar si el usuario existe
    $uidExists = uidExists($conn, $erabiltzaile, $erabiltzaile);

    // Mostrar información de depuración
    //var_dump($uidExists);

    if (!$uidExists) {
        header("Location: ../login.php?error=wronglogin");
        exit();
    }

    // Comprobar la contraseña
    $pasHashed = $uidExists["erabiltzailePasahitza"];
    $checkPas = password_verify($pasahitza, $pasHashed);

    // Mostrar información de depuración
    //var_dump($checkPas);

    if ($checkPas === false) {
        header("Location: ../login.php?error=wronglogin");
        exit();
    }elseif ($checkPas === true) {
        // Iniciar la sesión y almacenar datos del usuario en $_SESSION
        
        $_SESSION["erabiltzaile"] = array(
            "erabiltzaileId" => $uidExists["erabiltzaileId"],
            "erabiltzaileIzena" => $uidExists["erabiltzaileIzena"],
            "erabiltzaileNAN" => $uidExists["erabiltzaileNAN"],
            "erabiltzaileEmail" => $uidExists["erabiltzaileEmail"],
            "erabiltzaileTlfn" => $uidExists["erabiltzaileTlfn"],
            "erabiltzaileJaiotzedata" => $uidExists["erabiltzaileJaiotzedata"],
            "erabiltzaile" => $uidExists["erabiltzaile"]
        );
        header("Location: ../index.php");
        exit();
    }
}




