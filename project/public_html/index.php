<?php
session_start();

$message = ''; // Variabele voor het weergeven van berichten

if (!isset($_SESSION['userid'])) {
    $message = 'U bent momenteel niet ingelogd. <a href="login.php">Klik hier om in te loggen.</a>';
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
<body class="bg-dark text-light">
    <div class="container text-center mt-5">
        <h1>Dashboard</h1>
        <p><?php echo $message; ?></p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
