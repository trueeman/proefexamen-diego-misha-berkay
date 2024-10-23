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
    $message = 'Welkom, u bent ingelogd!';
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
$sqlGetPartijen = "SELECT 
    p.partijnaam, 
    p.datum_oprichting, 
    p.is_actief, 
    p.leider_id, 
    g.gebruikersnaam AS leider_gebruikersnaam 
FROM 
    partijen p 
INNER JOIN 
    gebruikers g ON p.leider_id = g.id;
";
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
                            <?php if (isset($_SESSION['userrank'])) : ?>
                                <?php if ($_SESSION['userrank'] == 3) : ?>
                                    <li class="nav-item">
                                        <a class="nav-link" href="register_partij.php">Partij registreren</a>
                                    </li>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php else : ?>
                            <li class="nav-item">
                                <a class="nav-link" href="login.php">Inloggen</a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container mt-5">
            <h1 class="text-center">Dashboard</h1>
            <p class="text-center"><?php echo $message; ?></p>

            <div class="row">
                <div class="col-md-6">
                    <h3>Geregistreerde Gebruikers:</h3>
                    <table class="table table-striped table-hover table-dark">
                        <thead>
                            <tr>
                                <th>Gebruikersnaam</th>
                                <th>Registratiedatum</th>
                                <th>User Rank</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($gebruikers) > 0): ?>
                                <?php foreach ($gebruikers as $gebruiker): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($gebruiker['gebruikersnaam']); ?></td>
                                        <td><?php echo htmlspecialchars($gebruiker['registratiedatum']); ?></td>
                                        <td><?php echo htmlspecialchars($gebruiker['userrank']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3">Geen geregistreerde gebruikers gevonden.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-6">
                    <h3>Geregistreerde Partijen:</h3>
                    <table class="table table-striped table-hover table-dark">
                        <thead>
                            <tr>
                                <th>Partijnaam</th>
                                <th>Datum van oprichting</th>
                                <th>Is de partij actief?</th>
                                <th>Partijleider</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($partijen) > 0): ?>
                                <?php foreach ($partijen as $partij): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($partij['partijnaam']); ?></td>
                                        <td><?php echo htmlspecialchars($partij['datum_oprichting']); ?></td>
                                        <td><?php echo $partij['is_actief'] ? "Ja" : "Nee"; ?></td>
                                        <td><?php echo htmlspecialchars($partij['leider_gebruikersnaam']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">Geen geregistreerde partijen gevonden.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>