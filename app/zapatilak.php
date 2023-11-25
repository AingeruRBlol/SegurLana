<?php
session_start();
include_once 'includes/dbh.inc.php'; 

if (!isset($_SESSION['erabiltzaile'])) {
    
    header("Location: login.php");
    exit();
}

$erabiltzaileId = $_SESSION['erabiltzaile']['erabiltzaileId'];


$sql = "SELECT * FROM Zapatilak WHERE erabiltzaileId = ?";
$stmt = mysqli_stmt_init($conn);

if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "i", $erabiltzaileId);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);
}

include_once 'header.php';
?>

<h1>Nire Zapatila Kolekzioa</h1>

<ul>
    <tr>
        <th>Izena</th>
        <th>Marka</th>
        <th>Mota</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<li><a href="edit_zapatila.php?zapatilaId=' . $row['IdProduktua'] . '" onclick="return openPopup(this.href);">' . $row['Izena'] . '</a> - ' . $row['Marka'] . '</a> - ' . $row['Mota'] . '</li>';
    }
    ?>
</ul>

<script>
function openPopup(url) {
    const width = 600;
    const height = 400;
    const left = window.innerWidth / 2 - width / 2;
    const top = window.innerHeight / 2 - height / 2;
    const options = `width=${width},height=${height},left=${left},top=${top}`;
    window.open(url, 'Popup Window', options);
    return false; 
}
</script>




<button onclick="openCenteredPopup()">Gehitu Zapatila Berria</button>

<script>
function openCenteredPopup() {
    const width = 600;
    const height = 400;
    const left = window.innerWidth / 2 - width / 2;
    const top = window.innerHeight / 2 - height / 2;
    const options = `width=${width},height=${height},left=${left},top=${top}`;
    window.open('zapatilak_add.php', 'Zapatila Berria', options);
}
</script>
