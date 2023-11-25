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
    if (isAccountBlocked($erabiltzaile, $conn)) {
        header("Location: ../login.php?error=accountlocked");
        exit();
    }
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
        if (isAccountBlocked($erabiltzaile, $conn)) {
            header("Location: ../login.php?error=accountlocked");
            exit();
        }
        recordBadLog($erabiltzaile, $conn, $pasahitza);
        if (maxLogTry($erabiltzaile, 5, $conn)) {
            blockAccount($erabiltzaile, $conn);
            header("Location: ../login.php?error=accountlocked");
            exit();
        }
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
        clearBadLogs($erabiltzaile, $conn);
        header("Location: ../index.php");
        exit();
    }
}


function recordBadLog($username, $conn, $pasahitza) {
    $timestamp = date("Y-m-d");

    $sql = "INSERT INTO logTxarrak (erabIzena, dataOrdua, pasahitza, hutsSaioak) VALUES ('$username', '$timestamp', '$pasahitza', 1)
            ON DUPLICATE KEY UPDATE dataOrdua = '$timestamp', hutsSaioak = hutsSaioak + 1";

    mysqli_query($conn, $sql);
}


function clearBadLogs($username, $conn) {
    $sql = "DELETE FROM logTxarrak WHERE erabIzena = '$username'";
    mysqli_query($conn, $sql);
}

function maxLogTry($username, $limite, $conn) {
    // Verificar si la cuenta está bloqueada
    $sqlBlokeatuta = "SELECT blokeatuta FROM logTxarrak WHERE erabIzena = '$username'";
    $resultadoBlokeatuta = mysqli_query($conn, $sqlBlokeatuta);

    if ($resultadoBlokeatuta) {
        $filaBlokeatuta = mysqli_fetch_assoc($resultadoBlokeatuta);
        $bloqueada = $filaBlokeatuta['blokeatuta'];

        if ($bloqueada == 1) {
            return true; // La cuenta está bloqueada
        }
    }

    // Verificar el número de intentos fallidos
    $sql = "SELECT hutsSaioak FROM logTxarrak WHERE erabIzena = '$username'";
    $resultado = mysqli_query($conn, $sql);

    if ($resultado) {
        $fila = mysqli_fetch_assoc($resultado);
        $intentosFallidos = $fila['hutsSaioak'];

        if ($intentosFallidos >= $limite) {
            // Bloquear la cuenta
            $sqlBloquear = "UPDATE logTxarrak SET blokeatuta = 1 WHERE erabIzena = '$username'";
            mysqli_query($conn, $sqlBloquear);

            return true; // La cuenta está bloqueada
        }
    }

    return false; // La cuenta no está bloqueada y no se superó el límite de intentos fallidos
}

function isAccountBlocked($username, $conn) {
    $sql = "SELECT blokeatuta FROM logTxarrak WHERE erabIzena = '$username'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        return $row['blokeatuta'] == 1;
    }

    return false;
}

function blockAccount($username, $conn) {
    $sql = "UPDATE logTxarrak SET blokeatuta = 1 WHERE erabIzena = '$username'";
    mysqli_query($conn, $sql);
}





