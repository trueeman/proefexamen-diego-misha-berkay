<?php
namespace Proefexamen\ElektronischStemmen;

use Dotenv\Dotenv;

class Database {

    public function __construct() {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();
    }

    public function getConn() {
        $dbhost = $_ENV['DB_HOST'];
        $dbuser = $_ENV['DB_USERNAME'];
        $dbpass = $_ENV['DB_PASSWORD'];
        $dbname = $_ENV['DB_DATABASE'];
    
        try {
            $conn = new \mysqli($dbhost, $dbuser, $dbpass, $dbname);
            return $conn;
        } catch (\mysqli_sql_exception $e) {
            // error_log($e->getMessage());
            return null;
        }
    }
}
?>