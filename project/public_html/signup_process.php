<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;

session_start();

// Maak connectie met de database
$db = new Database;
$conn = $db->getConn();

// Controleer of data verzonden
if (!isset($_POST["email"])) { 
    die("email not set"); 
}
if (!isset($_POST["username"])) { 
    die("username not set"); 
}
if (!isset($_POST["password"])) { 
    die("password not set"); 
}

// Check of gebruikersnaam bestaat
$sqlCheckIfExist = "SELECT * FROM gebruikers WHERE gebruikersnaam = ?";
$stmt = $conn->prepare($sqlCheckIfExist);
$stmt->bind_param("s", $_POST['username']);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    die("gebruikersnaam bestaat al");
}

// Insert nieuwe gebruiker
$sqlInsertNewUser = "INSERT INTO gebruikers (gebruikersnaam, wachtwoord) VALUES (?, ?)";
$stmt = $conn->prepare($sqlInsertNewUser);
$stmt->bind_param("ss", $_POST['username'], $_POST['password']);
$stmt->execute();

// Redirect to login page
header("Location: login.php");
exit();

?>