<?php
header('X-Frame-Options: SAMEORIGIN');
include_once 'header.php';

session_start();


$_SESSION['csrf_token'] = bin2hex(random_bytes(32));
$csrf_token = $_SESSION['csrf_token'];
?>

<section class="signup-form">
    <h2>Sign Up</h2>
    <div class="signup-form-form">
        <form action="includes/signup.inc.php" method="post">
          
            <input type="hidden" name="csrf_token" value="<?php echo $csrf_token; ?>">

            <input type="text" name="erabiltzaile" placeholder="Ezizena...">
            <input type="password" name="pasahitza" placeholder="Pasahitza...">
            <input type="text" name="izenAbizena" placeholder="Izen Abizenak...">
            <input type="text" name="nan" placeholder="NANa...">
            <input type="text" name="telefonoa" placeholder="Telefonoa...">
            <input type="text" name="email" placeholder="Emaila...">
            <input type="date" name="data" placeholder="Jaiotze Data...">
            <button type="submit" name="submit">Sign Up</button>
        </form>
    </div>

    <?php
    if(isset($_GET["error"])){
        if ($_GET["error"] == "emptyinput") {
            echo "<p>Bete hutsune guztiak!</p>";
        }
        if ($_GET["error"] == "usernametaken") {
            echo "<p>Beste ezizen bat aukeratu!</p>";
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
        elseif ($_GET["error"] == "invalidname"){
            echo "<p>Izen egokia idatzi!</p>";
        }
        elseif ($_GET["error"] == "invalidtlfn"){
            echo "<p>Telefono zenbaki formatu egokia erabili!</p>";
        }
        elseif ($_GET["error"] == "none"){
            echo "<p>Erregistratu zara!</p>";
        }
    }
    ?>
</section>

<?php
include_once 'footer.php';
?>
