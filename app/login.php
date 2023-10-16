<?php
    include_once 'header.php';  
?>
    <section class="login-form">
        <h2>Log In</h2>
        <div class="login-form-form">
            <form action="includes/login.inc.php" method="post">
                <input type="text" name="erabiltzaile" placeholder="Ezizena...">
                <input type="password" name="pasahitza" placeholder="Pasahitza...">
                <button type="submit" name="submit">Log In</button>
            </form>
        </div>
        <?php
        if(isset($_GET["error"])){
            if ($_GET["error"] == "emptyinput") {
                echo "<p>Bete hutsune guztiak!</p>";
            }
            elseif ($_GET["error"] == "wronglogin"){
                echo "<p>Erabiltzaile edo pasahitza okerrak!</p>";
            }
        }
    ?>
    </section>
    
    
<?php
    include_once 'footer.php';
?>