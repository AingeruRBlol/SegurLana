<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>STONKX</title>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
	<nav>
        <nav class="nav">
        <div class="nav__container">
        <h1 class="nav__title">STONKX</h1>
		<ul class="menu-horizontal">
			<li><a href="#">Hasiera</a></li>
			<li>
				<a href="#">Zapatilak</a>
				<ul class="menu-vertical">
					<li><a href="curso-html.html">Html</a></li>
					<li><a href="#">Css</a></li>
					<li><a href="#">Javascript</a></li>
				</ul>
			</li>
			<li>
				<a href="#">Berriak</a>
				<ul class="menu-vertical">
					<li><a href="#">Anual</a></li>
					<li><a href="#">Mensual</a></li>
				</ul>
			</li>
            <li>
				<a href="#">Saioa</a>
				<ul class="menu-vertical">
					<li><a href="#">Saioa hasi</a></li>
					<li><a href="#">Erregistratu</a></li>
				</ul>
			</li>
</div>
</nav>
		</ul>
	</nav>
</body>
</html>

<?php
include_once 'header.php';
?>
<?php
session_start();

// Resto de tu código
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
   
<?php
include_once 'footer.php';
?>
