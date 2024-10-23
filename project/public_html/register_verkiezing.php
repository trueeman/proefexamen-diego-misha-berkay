<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;

session_start();

// Maak connectie met de database
$db = new Database;
$conn = $db->getConn();

$message = '';

// Verwerk het formulier als het is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $verkiezingnaam = $_POST['verkiezingnaam'];
    $verkiezingssoort = $_POST['verkiezingssoort'];
    $startdatum = $_POST['startdatum'];
    $einddatum = $_POST['einddatum'];

    // Controleer of de verkiezing al bestaat
    $sqlCheck = "SELECT COUNT(*) FROM verkiezingen WHERE verkiezingnaam = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $verkiezingnaam);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($count > 0) {
        $message = "De verkiezing bestaat al.";
    } else {
        // Bereid de SQL-insert statement voor
        $sql = "INSERT INTO verkiezingen (verkiezingnaam, verkiezingssoort, startdatum, einddatum) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $verkiezingnaam, $verkiezingssoort, $startdatum, $einddatum);

        if ($stmt->execute()) {
            $message = "De verkiezing is succesvol geregistreerd.";
            header("Location: register_verkiezing.php");
            exit();
        } else {
            $message = "Er is een fout opgetreden: " . $stmt->error;
        }
    }
}

// Haal de userrank op van de ingelogde gebruiker
$sqlGetUserRank = "SELECT userrank FROM gebruikers WHERE id = ?";
$stmtGetUserRank = $conn->prepare($sqlGetUserRank);
$stmtGetUserRank->bind_param("i", $_SESSION['userid']);
$stmtGetUserRank->execute();
$resultUserRank = $stmtGetUserRank->get_result();
$user = $resultUserRank->fetch_assoc();

// Controleer of de userrank gelijk is aan 2
if ($user['userrank'] != 3) {
    $message = 'U heeft geen toegang tot deze pagina.';
    header("Location: index.php"); // Redirect
    exit;
} else {
    $message = 'Welkom, u bent ingelogd!';
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verkiezing Registreren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <nav class="navbar navbar-expand-lg navbar-light bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">
                    <img src="https://www.techniekcollegerotterdam.nl/assets/tcr-logo-a6a45f6beeaae69f30221d89d2a3e4ba1e2696114d5587459bf6a5dcf3603228.svg" alt="Logo" height="30">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="index.php">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Stemmen</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav ms-auto">
                        <?php if (isset($_SESSION["userid"])) : ?>
                            <li class="nav-item me-2">
                                <a class="nav-link" href="logout.php">Uitloggen</a>
                            </li>
                            <?php if ($_SESSION["userrank"] == 3) : ?>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="register_partij.php">Partij registreren</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="register_verkiezing.php">Verkiezing aanmaken</a>
                                </li>
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
        <br>
        <h1>Registreer een nieuwe verkiezing</h1>
        <p><?php echo $message; ?></p>
        <form action="register_verkiezing.php" method="post">
            <div class="mb-3">
                <label for="verkiezingnaam" class="form-label">Verkiezingnaam</label>
                <input type="text" class="form-control" id="verkiezingnaam" name="verkiezingnaam" required>
            </div>
            <div class="mb-3">
                <label for="verkiezingssoort" class="form-label">Verkiezingssoort</label>
                <input type="text" class="form-control" id="verkiezingssoort" name="verkiezingssoort" required>
            </div>
            <div class="mb-3">
                <label for="startdatum" class="form-label">Startdatum</label>
                <input type="date" class="form-control" id="startdatum" name="startdatum" required>
            </div>
            <div class="mb-3">
                <label for="einddatum" class="form-label">Einddatum</label>
                <input type="date" class="form-control" id="einddatum" name="einddatum" required>
            </div>
            <button type="submit" class="btn btn-primary">Registreer verkiezing</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
