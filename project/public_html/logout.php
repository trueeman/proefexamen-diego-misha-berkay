<?php
session_start();

// Verwijder alle sessiegegevens
session_unset();
session_destroy();

// Redirect naar de login-pagina
header("Location: login.php");
exit;
?>
