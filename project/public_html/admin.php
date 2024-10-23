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
    header("Location: login.php"); // Redirect naar login als niet ingelogd
    exit;
} else {
    // Haal de userrank op van de ingelogde gebruiker
    $sqlGetUserRank = "SELECT userrank FROM gebruikers WHERE id = ?";
    $stmtGetUserRank = $conn->prepare($sqlGetUserRank);
    $stmtGetUserRank->bind_param("i", $_SESSION['userid']);
    $stmtGetUserRank->execute();
    $resultUserRank = $stmtGetUserRank->get_result();
    $user = $resultUserRank->fetch_assoc();

    // Controleer of de userrank gelijk is aan 2
    if ($user['userrank'] != 2) {
        $message = 'U heeft geen toegang tot deze pagina.';
        header("Location: index.php"); // Redirect
        exit;
    } else {
        $message = 'Welkom, u bent ingelogd!';
    }
}

// Verwerk het formulier voor het bijwerken van "is verkiesbaar" status voor meerdere gebruikers
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_verkiesbaarheid'])) {
    if (isset($_POST['verkiesbaar'])) {
        foreach ($_POST['verkiesbaar'] as $userId => $isVerkiesbaar) {
            $isVerkiesbaarValue = ($isVerkiesbaar == 'on') ? 1 : 0; // Update met waarde 1 voor verkiesbaar, 0 voor onverkiesbaar
            $sqlUpdateUser = "UPDATE gebruikers SET userrank = ? WHERE id = ?";
            $stmtUpdateUser = $conn->prepare($sqlUpdateUser);
            $stmtUpdateUser->bind_param("ii", $isVerkiesbaarValue, $userId);

            if (!$stmtUpdateUser->execute()) {
                $message = "Er is een fout opgetreden bij het bijwerken: " . $stmtUpdateUser->error;
            }
        }
        $message = "De verkiesbaarheidsstatus van de gebruikers is bijgewerkt.";
    } else {
        $message = "Geen gebruikers geselecteerd.";
    }
}

// Haal alle geregistreerde partijen op
$sqlGetPartijen = "SELECT partijnaam, datum_oprichting, is_actief, leider_id FROM partijen";
$stmt = $conn->prepare($sqlGetPartijen);
$stmt->execute();
$result = $stmt->get_result();
$partijen = $result->fetch_all(MYSQLI_ASSOC);

// Haal alle geregistreerde gebruikers op
$sqlGetUsers = "SELECT id, gebruikersnaam, registratiedatum, userrank FROM gebruikers";
$stmtUsers = $conn->prepare($sqlGetUsers);
$stmtUsers->execute();
$resultUsers = $stmtUsers->get_result();
$gebruikers = $resultUsers->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Geregistreerde Partijen en Gebruikers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/theme.css">
</head>
<body class="bg-dark text-light">
    <div class="container text-center mt-5">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
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
                    <ul class="navbar-nav ms-auto d-flex">
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
                </div>
            </div>
        </nav>

        <!-- Content -->
        <div class="container mt-5">
            <h1 class="text-center">Admin paneel</h1>
            <p class="text-center"><?php echo $message; ?></p>

            
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>
