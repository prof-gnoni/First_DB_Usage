<?php

$host = "localhost";
$port = 3306;
$user = "root";
$pass = "";
$db = "first_db_usage";

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage() . "<br>";
    exit("Si è verificato un errore di connessione al database. Riprova più tardi.");
}

