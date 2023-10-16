<?php
    include_once 'header.php';
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Verifica si el usuario está autenticado, por ejemplo, mediante un sistema de inicio de sesión.
if (!isset($_SESSION['erabiltzaile'])) {
    header("Location: login.php"); // Redirige a la página de inicio de sesión si el usuario no está autenticado.
    exit();
}

// Muestra los datos del usuario.
$usuario = $_SESSION['erabiltzaile'];

// Accede a los valores de la variable de sesión de esta manera:
echo "Izena: " . $usuario['erabiltzaileIzena'] . "<br>";
echo "NANa: " . $usuario['erabiltzaileNAN'] . "<br>";
echo "Telefonoa: " . $usuario['erabiltzaileTlfn'] . "<br>";
echo "Jaiotze data: " . $usuario['erabiltzaileJaiotzedata'] . "<br>";
echo "Email-a: " . $usuario['erabiltzaileEmail'] . "<br>";
echo "Ezizena: " . $usuario['erabiltzaile'] . "<br>";
echo "<a href='edit.php'>Editar</a>";

?>




