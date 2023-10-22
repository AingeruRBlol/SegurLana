<?php
    session_start();
?>
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Verifica si el usuario está autenticado.
if (!isset($_SESSION['erabiltzaile'])) {
    header("Location: login.php");
    exit();
}

require_once 'includes/dbh.inc.php'; // Incluye el archivo de conexión a la base de datos.

// Obtén los datos del usuario actual desde la sesión.
$usuario = $_SESSION['erabiltzaile'];

// Inicializa una variable para controlar la redirección a profile.php.
$redirectToProfile = false;

// Maneja la actualización de datos si se envía el formulario.
if (isset($_POST['submit'])) {
    // Aquí debes realizar la validación de datos recibidos del formulario.

    $newIzena = $_POST['newIzena'];
    $newNAN = $_POST['newNAN'];
    $newTelefonoa = $_POST['newTelefonoa'];
    $newJaiotzeData = $_POST['newJaiotzeData'];
    $newEmail = $_POST['newEmail'];

    require_once 'includes/functions.inc.php';

    // Realiza la actualización en la base de datos.
    if (invalidNan($newNAN) !== false){
        header("location: ../edit.php?error=invalidnan");
        exit();
    }
    if (invalidEmail($newEmail) !== false){
        header("location: ../edit.php?error=invalidemail");
        exit();
    }
    if (invalidDate($newJaiotzeData) !== false){
        header("location: ../edit.php?error=invaliddate");
        exit();
    }
    if (invalidTlfn($newTelefonoa) !== false){
        header("location: ../edit.php?error=invalidtlfn");
        exit();
    }
    if (invalidName($newIzena) !== false){
        header("location: ../edit.php?error=invalidname");
        exit();
    }

    $sql = "UPDATE erabiltzaileak SET erabiltzaileIzena=?, erabiltzaileNAN=?, erabiltzaileTlfn=?, erabiltzaileJaiotzedata=?, erabiltzaileEmail=? WHERE erabiltzaileId=?";

    $stmt = mysqli_stmt_init($conn);
    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $newIzena, $newNAN, $newTelefonoa, $newJaiotzeData, $newEmail, $usuario['erabiltzaileId']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        $_SESSION['erabiltzaile']['erabiltzaileIzena'] = $newIzena;
        $_SESSION['erabiltzaile']['erabiltzaileNAN'] = $newNAN;
        $_SESSION['erabiltzaile']['erabiltzaileTlfn'] = $newTelefonoa;
        $_SESSION['erabiltzaile']['erabiltzaileJaiotzedata'] = $newJaiotzeData;
        $_SESSION['erabiltzaile']['erabiltzaileEmail'] = $newEmail;

        // Marca la variable para redirigir a profile.php
        echo '<script>window.close(); window.opener.location.reload();</script>';
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Editar Perfil</title>
</head>
<body>
    <h2>Editar Perfil</h2>
    <!-- Formulario de edición -->
    <form action="edit.php" method="post">
        <!-- Campos de edición para los datos del usuario -->
        <label for="newIzena">Nuevo Nombre:</label>
        <input type="text" name="newIzena" value="<?php echo $usuario['erabiltzaileIzena']; ?>"><br>

        <label for="newNAN">Nuevo DNI:</label>
        <input type="text" name="newNAN" value="<?php echo $usuario['erabiltzaileNAN']; ?>"><br>

        <label for="newTelefonoa">Nuevo Teléfono:</label>
        <input type="text" name="newTelefonoa" value="<?php echo $usuario['erabiltzaileTlfn']; ?>"><br>

        <label for="newJaiotzeData">Nueva Fecha de Nacimiento:</label>
        <input type="text" name="newJaiotzeData" value="<?php echo $usuario['erabiltzaileJaiotzedata']; ?>"><br>

        <label for="newEmail">Nuevo Correo Electrónico:</label>
        <input type="text" name="newEmail" value="<?php echo $usuario['erabiltzaileEmail']; ?>"><br>

        <!-- Botón de envío del formulario -->
        <input type="submit" name="submit" value="Guardar Cambios">
    </form>
    <?php
        if(isset($_GET["error"])){
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Bete hutsune guztiak!</p>";
            }
            elseif ($_GET["error"] == "invalidUid"){
                echo "<p>Aukeratu ezizen egokia!</p>";
            }
            elseif ($_GET["error"] == "invalidemail"){
                echo "<p>Aukeratu email egokia!</p>";
            }
            elseif ($_GET["error"] == "invalidnan"){
                echo "<p>Erabili NAN formatu egokia!</p>";
            }
            elseif ($_GET["error"] == "invaliddate"){
                echo "<p>Erabili data formatu egokia, (uuuu-hh-ee)!</p>";
            }
            elseif ($_GET["error"] == "invalidtlfn"){
                echo "<p>Idatzi telefono zenbaki egokia!</p>";
            }
            elseif ($_GET["error"] == "invalidname"){
                echo "<p>Idatzi izen egokia, ez zara ziborg bat!</p>";
            }

        }
    ?>
</body>
</html>
