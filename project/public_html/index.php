<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;

session_start();

// Maak connectie met de database
$db = new Database;
$conn = $db->getConn();

$message = ''; // Variabele voor het weergeven van berichten
if (!isset($_SESSION['userid'])) {
    $message = 'U bent momenteel niet ingelogd.';
} else {
    $message = 'Welkom, u bent ingelogd!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Proefexamen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/theme.css">
</head>
</div>


<body class="bg-dark text-light">
    <div class="container text-center mt-5">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="">
                    <img src="https://www.techniekcollegerotterdam.nl/assets/tcr-logo-a6a45f6beeaae69f30221d89d2a3e4ba1e2696114d5587459bf6a5dcf3603228.svg" alt="Logo" height="30" class="d-inline-block align-text-top">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Stemmen</a>
                        </li>
                    </ul>
                    <<ul class="navbar-nav ms-auto d-flex">
                 <?php if (isset($_SESSION["userid"])) : ?>
                    <li class="nav-item me-2">
                    <a class="nav-link" href="logout.php">Uitloggen</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="register_partij.php">Partij registreren</a>
                    </li>
                 <?php else : ?>
                    <li class="nav-item">
                    <a class="nav-link" href="login.php">Inloggen</a>
                    </li>
                 <?php endif; ?>
                    </ul>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <br>
        <h1>Dashboard</h1>
        <p><?php echo $message; ?></p>
    </div>
    <div class="container">
    <h3>Geregistreerde gebruikers:</h3>
    <?php
        $sqlGetUsers = "SELECT gebruikersnaam, registratiedatum, is_verkiesbaar FROM gebruikers";
        $stmt = $conn -> prepare($sqlGetUsers);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Loop door alle gebruikers en geef hun gegevens weer
            while ($row = $result->fetch_assoc()) {
                $gebruikersnaam = htmlspecialchars($row['gebruikersnaam']);  // Voorkom XSS-aanvallen
                $registratiedatum = htmlspecialchars($row['registratiedatum']);
                $is_verkiesbaar = $row['is_verkiesbaar'] ? "Ja" : "Nee";

                echo "<p>Gebruikersnaam: $gebruikersnaam<br>Registratiedatum: $registratiedatum<br>Is verkiesbaar: $is_verkiesbaar</p>";
            }
        } else {
            echo "<p>Geen geregistreerde gebruikers gevonden.</p>";
        }
        ?>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
