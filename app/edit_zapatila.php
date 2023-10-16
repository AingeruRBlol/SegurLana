<?php
session_start();
include_once 'includes/dbh.inc.php'; // Incluye tu archivo de conexión a la base de datos.

if (!isset($_SESSION['erabiltzaile'])) {
    // Si no hay una sesión activa, redirige a la página de inicio de sesión.
    header("Location: login.php");
    exit();
}

$erabiltzaileId = $_SESSION['erabiltzaileId']; // Obtiene el ID de usuario de la sesión.

// Verifica si se proporciona un ID de zapatilla en la URL.
if (isset($_GET['zapatilaId'])) {
    $zapatilaId = $_GET['zapatilaId'];
    
    // Consulta SQL para obtener los detalles de la zapatilla con el ID proporcionado.
    $sql = "SELECT * FROM Zapatilak WHERE IdProduktua = ? AND erabiltzaileId = ?";
    $stmt = mysqli_stmt_init($conn);
    
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $zapatilaId, $erabiltzaileId);
        mysqli_stmt_execute($stmt);
        
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        if (!$row) {
            // La zapatilla no pertenece al usuario actual.
            // Puedes manejar esto según tus necesidades, como redirigir o mostrar un mensaje de error.
            header("Location: zapatilak.php");
            exit();
        }
    } else {
        // Manejar el error de consulta SQL.
        // Puedes redirigir o mostrar un mensaje de error.
        header("Location: zapatilak.php");
        exit();
    }
} else {
    // No se proporcionó un ID de zapatilla en la URL.
    // Puedes manejar esto según tus necesidades, como redirigir o mostrar un mensaje de error.
    header("Location: zapatilak.php");
    exit();
}

// Procesar el formulario de edición y eliminación
if (isset($_POST['submit'])) {
    $izena = $_POST['izena'];
    $marka = $_POST['marka'];
    $kolorea = $_POST['kolorea'];
    $mota = $_POST['mota'];
    $prezioa = $_POST['prezioa'];
    $neurria = $_POST['neurria'];
    
    // Consulta SQL para actualizar los detalles de la zapatilla.
    $sql = "UPDATE Zapatilak 
            SET Izena = ?, Marka = ?, Kolorea = ?, Mota = ?, Prezioa = ?, Neurria = ?
            WHERE IdProduktua = ? AND erabiltzaileId = ?";

    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssssssii", $izena, $marka, $kolorea, $mota, $prezioa, $neurria, $zapatilaId, $erabiltzaileId);
        
        if (mysqli_stmt_execute($stmt)) {
            // La zapatilla se actualizó con éxito.
            // Puedes redirigir a la página de zapatilak o mostrar un mensaje de éxito.
            echo '<script>window.close(); window.opener.location.reload();</script>';
            exit();
        } else {
            // Manejar errores en la actualización.
            // Puedes redirigir o mostrar un mensaje de error.
            echo "Error en la actualización de la zapatilla: " . mysqli_error($conn);
        }
    }
}

if (isset($_POST['delete'])) {
    // Acción de eliminación
    $sql = "DELETE FROM Zapatilak WHERE IdProduktua = ? AND erabiltzaileId = ?";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ii", $zapatilaId, $erabiltzaileId);
        
        if (mysqli_stmt_execute($stmt)) {
            // La zapatilla se eliminó con éxito.
            // Puedes redirigir a la página de zapatilak o mostrar un mensaje de éxito.
            echo '<script>window.close(); window.opener.location.reload();</script>';

            exit();
        } else {
            // Manejar errores en la eliminación.
            // Puedes redirigir o mostrar un mensaje de error.
            echo "Error en la eliminación de la zapatilla: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Zapatila</title>
</head>
<body>
    <h1>Editar Zapatila</h1>

    <!-- Formulario para editar los detalles de la zapatilla -->
    <form method="post" action="">
        <label for="izena">Izena:</label>
        <input type="text" name="izena" value="<?php echo $row['Izena']; ?>" required><br>

        <label for="marka">Marka:</label>
        <input type="text" name="marka" value="<?php echo $row['Marka']; ?>" required><br>

        <label for="kolorea">Kolorea:</label>
        <input type="text" name="kolorea" value="<?php echo $row['Kolorea']; ?>" required><br>

        <label for="mota">Mota:</label>
        <input type="text" name="mota" value="<?php echo $row['Mota']; ?>" required><br>

        <label for="prezioa">Prezioa:</label>
        <input type="text" name="prezioa" value="<?php echo $row['Prezioa']; ?>" required><br>

        <label for="neurria">Neurria:</label>
        <input type="text" name="neurria" value="<?php echo $row['Neurria']; ?>" required><br>

        <button type="submit" name="submit">Gorde Aldaketak</button>
        
        <!-- Botón para eliminar la zapatilla -->
        <button type="submit" name="delete" style="background-color: red; color: white;">Zapatila Ezabatu</button>
    </form>
    

</body>
</html>

