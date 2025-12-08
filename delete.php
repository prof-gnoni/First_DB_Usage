<?php
require_once "auth_check.php";
// delete.php
global $conn;
require_once "dbConfig.php";

// 1. Verifica presenza ID
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // 2. Preparazione Query (Sicurezza massima contro SQL Injection)
        $sql = "DELETE FROM utente WHERE idUtente = :id";
        $stmt = $conn->prepare($sql);

        // 3. Esecuzione
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // 4. Redirect con successo
        header("Location: index.php?status=deleted");
        exit();

    } catch (PDOException $e) {
        error_log("Errore Cancellazione: " . $e->getMessage());
        exit("Errore durante l'eliminazione.");
    }
} else {
    // Se l'ID non c'è, torna alla home
    header("Location: index.php");
    exit();
}