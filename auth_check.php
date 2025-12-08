<?php
// auth_check.php

// 1. Avviamo (o recuperiamo) la sessione
// È fondamentale che questa sia la PRIMA istruzione PHP
session_start();

// 2. Controllo Login: "Hai il biglietto?"
// Se la variabile 'logged_in' non esiste o non è true, via!
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Reindirizza al login
    header("Location: login.php");
    exit;
}

/**
 * 3. Funzione Helper: "Sei il capo?"
 * Restituisce TRUE se l'utente appartiene al gruppo 'Amministratori'.
 * Restituisce FALSE se è 'Standard' o altro.
 */
function isAdmin() {
    // Nota: 'Amministratori' deve essere SCRITTO IDENTICO a come è nel Database (tabella gruppo)
    return isset($_SESSION['gruppo']) && $_SESSION['gruppo'] === 'Amministratori';
}
?>