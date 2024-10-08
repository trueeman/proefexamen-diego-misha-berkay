<?php
namespace Proefexamen\ElektronischStemmen;

class Database {
    private function getConn() {
        $dbhost = "localhost";
        $dbuser = "root";
        $dbpass = "123456";
        $dbname = "user";

        $conn = new \mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}

?>