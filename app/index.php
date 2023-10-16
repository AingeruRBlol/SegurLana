<?php
session_start(); // Iniciar la sesión al principio del archivo
include_once 'header.php';
?>


<section class="index-intro">
    <?php
    if (isset($_SESSION["erabiltzaile"])) 
    {
        echo "<p>Ongi etorri, " . $_SESSION["erabiltzaile"]["erabiltzaile"] . "!</p>";
    } 
    else 
    {
        echo "<p>Sesión no iniciada</p>";
    }
    ?>
</section>
<body>
    <header>
        <h1>STONKX</h1>
        <p>Zure zapatila kolekzio birtuala</p>
    </header>
    <img class="emp" src="irudi/zapas.jpg" alt="Álvaro Donoren hankak">
    <img class="fondo-emp" src="irudi/zapas.jpg" alt="7jub">
    <div class="icons">
        <i class='bx bxl-invision'></i>
        <i class='bx bxl-dropbox' ></i>
        <i class='bx bxl-linkedin' ></i>
    </div>
</body>

<?php
include_once 'footer.php';
?>

