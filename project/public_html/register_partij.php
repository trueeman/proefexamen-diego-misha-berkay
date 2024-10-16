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
    $leider = $_POST['leider'];

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
        $sql = "INSERT INTO partijen (partijnaam, datum_oprichting, is_actief, leider) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssis", $partijnaam, $datum_oprichting, $is_actief, $leider);

        if ($stmt->execute()) {
            $message = "De partij is succesvol geregistreerd.";
            // Leeg het formulier of herlaad om dubbele indiening te voorkomen
            header("Location: register_partij.php");
            exit();
        } else {
            $message = "Er is een fout opgetreden: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partij Registreren</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
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
        <a href="index.php" class="btn btn-secondary mt-3">Terug naar dashboard</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</
