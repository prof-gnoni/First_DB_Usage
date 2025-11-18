<?php
// db_connect.php
function getDbConnection()
{
    // Carica la configurazione
    $config = require 'config.php';

    // Costruzione del DSN (Data Source Name)
    $dsn = "mysql:host={$config['host']};dbname={$config['db_name']};charset={$config['charset']}";

    // Opzioni per rendere la connessione robusta e sicura
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,        // Lancia eccezioni in caso di errore
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,   // Restituisce i dati come array associativi
        PDO::ATTR_EMULATE_PREPARES => false,                // Disabilita l'emulazione: usa veri prepared statements
        PDO::ATTR_PERSISTENT => false,                      // Disabilita connessioni persistenti (generalmente meglio per app web standard)
    ];

    try {
        // Tentativo di connessione
        $pdo = new PDO($dsn, $config['username'], $config['password'], $options);
        return $pdo;

    } catch (PDOException $e) {
        // GESTIONE ERRORE DA PRODUZIONE

        // 1. Log dell'errore reale nel file di log del server (invisibile all'utente)
        // Include codice errore, messaggio e file dove è successo
        error_log("Errore Connessione Database: " . $e->getMessage() . " in " . $e->getFile() . ":" . $e->getLine());

        // 2. Interruzione script e messaggio generico per l'utente
        // Non mostrare MAI $e->getMessage() all'utente finale!
        http_response_code(500); // Segnala errore server
        exit('Si è verificato un errore di connessione al database. Riprova più tardi.');
    }
}