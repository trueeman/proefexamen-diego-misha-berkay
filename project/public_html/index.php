<?php
require_once("../vendor/autoload.php");
use Proefexamen\ElektronischStemmen\Database;

$db = new Database;
if ($db) {
    echo "connectie geslaagd";
}

?>