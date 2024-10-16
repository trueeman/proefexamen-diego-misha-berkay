<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;

session_start();

// Maak connectie met de database
$db = new Database;
$conn = $db->getConn();

// Controleer of data verzonden is
if (!isset($_POST["username"])) {
    die("Gebruikersnaam niet ingevuld.");
}
if (!isset($_POST["password"])) {
    die("Wachtwoord niet ingevuld.");
}

// Bereid query voor om gebruiker te vinden
$sql = "SELECT * FROM gebruikers WHERE gebruikersnaam = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $_POST['username']);
$stmt->execute();
$result = $stmt->get_result();

// Controleer of de gebruiker bestaat
if ($result->num_rows === 0) {
    die("Ongeldig gebruikersnaam.");
}

// Haal de gebruikersgegevens op
$user = $result->fetch_assoc();

// Controleer wachtwoord (aangenomen dat wachtwoorden gehasht zijn)
if ($_POST['password'] == $user['wachtwoord']) {
    // Sla gebruikersinformatie op in de sessie
    $_SESSION['userid'] = $user['id'];
    
    // Redirect naar dashboard of gewenste pagina
    header("Location: index.php");
    exit();
} else {
    die("Ongeldig wachtwoord.");
}
?>
