<?php
// dbConfig.php

$host = "127.0.0.1";
//$port = 3306;
$port = 8889;
$user = "root";
$pass = "root";
$db   = "first_db_usage";
$conn = null;

// 1. Definiamo il charset (UTF8MB4 è lo standard moderno)
$charset = 'utf8mb4';

// 2. Costruiamo il DSN includendo il charset
$dsn = "mysql:host=$host;port=$port;dbname=$db;charset=$charset";

// 3. Opzioni per la sicurezza e l'usabilità
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Lancia eccezioni su errori SQL
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Solo array associativi (più pulito)
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disabilita emulazione (più sicuro)
];

try {
    // 4. Creazione istanza con le opzioni
    $conn = new PDO($dsn, $user, $pass, $options);

} catch (PDOException $e) {
    // 5. GESTIONE SICURA DELL'ERRORE

    // Scrivi l'errore vero SOLO nel log di sistema (invisibile all'utente)
    error_log("Errore DB: " . $e->getMessage());

    // All'utente mostra solo questo, senza dettagli tecnici
    exit("Si è verificato un errore di connessione al database. Riprova più tardi.");
}