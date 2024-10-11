<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;

session_start();

// Maak connectie met de database
$db = new Database;

// Controleer of het formulier is verzonden
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ontvang formuliergegevens
    $email = $_POST['email'];
    $gebruikersnaam = $_POST['username'];
    $wachtwoord = password_hash($_POST['password'], PASSWORD_DEFAULT);  // Hash het wachtwoord

    // Controleer of e-mail en gebruikersnaam niet al bestaan
    $query = $db->prepare("SELECT * FROM gebruikers WHERE email = :email OR gebruikersnaam = :gebruikersnaam");
    $query->execute(['email' => $email, 'gebruikersnaam' => $gebruikersnaam]);
    $user = $query->fetch();

    if ($user) {
        // Gebruiker bestaat al, geef een foutmelding
        $_SESSION['error'] = "E-mail of gebruikersnaam is al in gebruik.";
        header("Location: signup.php");
    } else {
        // Voeg nieuwe gebruiker toe aan de database
        $query = $db->prepare("INSERT INTO gebruikers (email, gebruikersnaam, wachtwoord) VALUES (:email, :gebruikersnaam, :wachtwoord)");
        $result = $query->execute([
            'email' => $email,
            'gebruikersnaam' => $gebruikersnaam,
            'wachtwoord' => $wachtwoord
        ]);

        if ($result) {
            // Succesvolle registratie, stuur gebruiker naar loginpagina
            $_SESSION['success'] = "Registratie succesvol. U kunt nu inloggen.";
            header("Location: login.php");
        } else {
            // Fout bij het invoegen van de gebruiker
            $_SESSION['error'] = "Er is een fout opgetreden bij de registratie.";
            header("Location: signup.php");
        }
    }
}
