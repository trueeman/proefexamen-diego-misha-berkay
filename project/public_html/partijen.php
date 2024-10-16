<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;

session_start();

// Maak connectie met de database
$db = new Database;
$conn = $db->getConn();

$message = '';

// Verwerk het bewerken van een partij
if (isset($_POST['edit'])) {
    $partij_id = $_POST['partij_id'];
    $partijnaam = $_POST['partijnaam'];
    $datum_oprichting = $_POST['datum_oprichting'];
    $is_actief = isset($_POST['is_actief']) ? 1 : 0; // 1 = TRUE, 0 = FALSE
    $leider = $_POST['leider'];

    // Update de partij in de database
    $sqlUpdate = "UPDATE partijen SET partijnaam = ?, datum_oprichting = ?, is_actief = ?, leider = ? WHERE id = ?";
    $stmtUpdate = $conn->prepare($sqlUpdate);
    $stmtUpdate->bind_param("ssisi", $partijnaam, $datum_oprichting, $is_actief, $leider, $partij_id);

    if ($stmtUpdate->execute()) {
        $message = "De partij is succesvol bijgewerkt.";
    } else {
        $message = "Er is een fout opgetreden bij het bijwerken: " . $stmtUpdate->error;
    }
}

// Haal alle geregistreerde partijen op
$sqlGetPartijen = "SELECT id, partijnaam, datum_oprichting, is_actief, leider FROM partijen";
$stmt = $conn->prepare($sqlGetPartijen);
$stmt->execute();
$result = $stmt->get_result();
$partijen = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geregistreerde Partijen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body class="bg-dark text-light">
    <div class="container mt-5">
        <h1>Geregistreerde Partijen</h1>
        <p><?php echo $message; ?></p>
        
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Partijnaam</th>
                    <th>Datum van oprichting</th>
                    <th>Is Actief?</th>
                    <th>Leider</th>
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($partijen) > 0): ?>
                    <?php foreach ($partijen as $partij): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($partij['partijnaam']); ?></td>
                            <td><?php echo htmlspecialchars($partij['datum_oprichting']); ?></td>
                            <td><?php echo $partij['is_actief'] ? "Ja" : "Nee"; ?></td>
                            <td><?php echo htmlspecialchars($partij['leider']); ?></td>
                            <td>
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $partij['id']; ?>">Bewerken</button>

                                <!-- Modal voor bewerken -->
                                <div class="modal fade" id="editModal<?php echo $partij['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editModalLabel">Bewerk Partij</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <form method="post">
                                                    <input type="hidden" name="partij_id" value="<?php echo $partij['id']; ?>">
                                                    <div class="mb-3">
                                                        <label for="partijnaam" class="form-label">Partijnaam</label>
                                                        <input type="text" class="form-control" id="partijnaam" name="partijnaam" value="<?php echo htmlspecialchars($partij['partijnaam']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="datum_oprichting" class="form-label">Datum van oprichting</label>
                                                        <input type="date" class="form-control" id="datum_oprichting" name="datum_oprichting" value="<?php echo htmlspecialchars($partij['datum_oprichting']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="leider" class="form-label">Naam van de leider</label>
                                                        <input type="text" class="form-control" id="leider" name="leider" value="<?php echo htmlspecialchars($partij['leider']); ?>" required>
                                                    </div>
                                                    <div class="mb-3 form-check">
                                                        <input type="checkbox" class="form-check-input" id="is_actief" name="is_actief" <?php echo $partij['is_actief'] ? 'checked' : ''; ?>>
                                                        <label class="form-check-label" for="is_actief">Is actief?</label>
                                                    </div>
                                                    <button type="submit" name="edit" class="btn btn-primary">Opslaan</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">Geen geregistreerde partijen gevonden.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <a href="index.php" class="btn btn-primary">Dashboard</a>
        <a href="register_partij.php" class="btn btn-primary">Nieuwe partij registreren</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
