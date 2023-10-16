<?php
// Incluye el archivo de conexión a la base de datos
require_once 'includes/dbh.inc.php'; // Asegúrate de que el nombre del archivo sea el correcto

// Verifica si el usuario ha iniciado sesión y obtiene su erabiltzaileId de la sesión
session_start();
if (!isset($_SESSION['erabiltzaile'])) {
    // Redirige a la página de inicio de sesión si el usuario no ha iniciado sesión
    header("Location: login.php");
    exit();
}

$erabiltzaileId = $_SESSION['erabiltzaile']['erabiltzaileId'];

if (isset($_POST['submit'])) {
    // Obtén los datos del formulario
    $izena = $_POST['izena'];
    $marka = $_POST['marka'];
    $kolorea = $_POST['kolorea'];
    $mota = $_POST['mota'];
    $prezioa = $_POST['prezioa'];
    $neurria = $_POST['neurria'];

    // Realiza la inserción de los datos en la tabla Zapatilak, incluyendo el erabiltzaileId
    $sql = "INSERT INTO Zapatilak (erabiltzaileId, Izena, Marka, Kolorea, Mota, Prezioa, Neurria) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "issssss", $erabiltzaileId, $izena, $marka, $kolorea, $mota, $prezioa, $neurria);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Redirige al usuario después de agregar la zapatilla
        echo '<script>window.close(); window.opener.location.reload();</script>';
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Agregar Zapatilla</title>
</head>
<body>
    <h1>Agregar Zapatilla</h1>

    <form method="post" action="">
        <label for="izena">Izena:</label>
        <input type="text" name="izena" required><br>

        <label for="marka">Marka:</label>
        <input type="text" name="marka" required><br>

        <label for="kolorea">Kolorea:</label>
        <input type="text" name="kolorea" required><br>

        <label for="mota">Mota:</label>
        <input type="text" name="mota" required><br>

        <label for="prezioa">Prezioa:</label>
        <input type="text" name="prezioa" required><br>

        <label for="neurria">Neurria:</label>
        <input type="text" name="neurria" required><br>

        <input type="submit" name="submit" value="Gehitu Zapatila">
    </form>
</body>
</html>
