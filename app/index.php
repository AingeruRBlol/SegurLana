<?php
    session_start();
    header('X-Frame-Options: SAMEORIGIN');
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy">	
	<title>STONKX</title>
	<link rel="stylesheet" href="estilo.css">
</head>
<body>
	<nav>
        <nav class="nav">
            <div class="nav__container">
                <h1 class="nav__title">STONKX</h1>
                <ul class="menu-horizontal">
                    <li><a href="index.php">Hasiera</a></li>
                    <li>
                        <a href="#">Zapatilak</a>
                        <ul class="menu-vertical">
                            <li><a href="zapatilak.php">Nireak</a></li>
                            <li><a href="zapatilak_add.php">Gehitu</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="berriak.php">Berriak</a>
                    </li>
                    <li>
                        <a href="#">Saioa</a>
                        <ul class="menu-vertical">
                            <li><a href="login.php">Saioa hasi</a></li>
                            <li><a href="signup.php">Erregistratu</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="profile.php">Profila</a>
                    </li>
                </ul>
            </div>
        </nav>
    </nav>

    <section class="index-intro">
        <?php
        if (isset($_SESSION["erabiltzaile"])) {
            echo "<p>Ongi etorri, " . $_SESSION["erabiltzaile"]["erabiltzaile"] . "!</p>";
        }
        ?>
    </section>

    <div align="center">
        <header>
            <h1>Zure Zapatila Katalogo Gogokoena</h1> 
			<p>Zein zapatilak dituzun eta hauen kudeaketa egokia nahi duzu? Zure erantzuna baiezkoa bada erregistratu zaitez STONKX-en. Zure zapatila katalogoa kudeatzeko aukera daukazu, zapatilak gehitzeko, neurri, prezio, kolore, mota... dena jakin dezakezu. Baita zapatila berriak gehitu ere.</p>        </header>
    </div>
</body>
</html>
