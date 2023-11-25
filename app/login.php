<?php
header('X-Frame-Options: SAMEORIGIN');
include_once 'header.php';
session_start();

$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$csrf_token = $_SESSION['csrf_token'];
?>



<section class="login-form">
    <h2>Log In</h2>
    <div class="login-form-form">
        <form action="includes/login.inc.php" method="post">
           
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <input type="text" name="erabiltzaile" placeholder="Ezizena...">
            <input type="password" name="pasahitza" placeholder="Pasahitza...">
            <button type="submit" name="submit">Log In</button>
        </form>
    </div>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Bete hutsune guztiak!</p>";
        } elseif ($_GET["error"] == "wronglogin") {
            echo "<p>Erabiltzaile edo pasahitza okerrak!</p>";
        } elseif ($_GET["error"] == "accountlocked") {
            echo "<p>Erabiltzaile kontua blokeatuta dago. Mesedez, jarri harremanetan administratzailearekin.</p>";
        }
    }
    ?>
</section>

<?php
include_once 'footer.php';
?>
