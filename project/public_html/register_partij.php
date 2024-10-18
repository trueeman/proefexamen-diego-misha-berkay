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
    $partijnaam = $_POST['partijnaam'];
    $datum_oprichting = $_POST['datum_oprichting'];
    $is_actief = isset($_POST['is_actief']) ? 1 : 0; // 1 = TRUE, 0 = FALSE
    $leider = $_POST['leider_id'];

    // Controleer of de partij al bestaat
    $sqlCheck = "SELECT COUNT(*) FROM partijen WHERE partijnaam = ?";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("s", $partijnaam);
    $stmtCheck->execute();
    $stmtCheck->bind_result($count);
    $stmtCheck->fetch();
    $stmtCheck->close();

    if ($count > 0) {
        $message = "De partij bestaat al.";
    } else {
        // Bereid de SQL-insert statement voor
        $sql = "INSERT INTO partijen (partijnaam, datum_oprichting, is_actief, leider_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $partijnaam, $datum_oprichting, $is_actief, $leider);

        if ($stmt->execute()) {
            $message = "De partij is succesvol geregistreerd.";
            header("Location: register_partij.php");
            exit();
        } else {
            $message = "Er is een fout opgetreden: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partij Registreren</title>
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
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="register_partij.php">Partij registreren</a>
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
        <br>
        <h1>Registreer een nieuwe partij</h1>
        <p><?php echo $message; ?></p>
        <form action="register_partij.php" method="post">
            <div class="mb-3">
                <label for="partijnaam" class="form-label">Partijnaam</label>
                <input type="text" class="form-control" id="partijnaam" name="partijnaam" required>
            </div>
            <div class="mb-3">
                <label for="datum_oprichting" class="form-label">Datum van oprichting</label>
                <input type="date" class="form-control" id="datum_oprichting" name="datum_oprichting" required>
            </div>
            <div class="mb-3">
                <label for="leider" class="form-label">Naam van de leider</label>
                <input type="text" class="form-control" id="leider" name="leider" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="is_actief" name="is_actief" checked>
                <label class="form-check-label" for="is_actief">Is actief?</label>
            </div>
            <button type="submit" class="btn btn-primary">Registreer partij</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
