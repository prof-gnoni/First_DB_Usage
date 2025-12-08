<?php
// logout.php

// 1. Recuperiamo la sessione esistente
session_start();

// 2. Svuotiamo tutte le variabili di sessione ($_SESSION diventa un array vuoto)
$_SESSION = [];

// 3. Cancelliamo il cookie di sessione dal browser
// Questo è un passaggio di sicurezza "extra" raccomandato dalla documentazione PHP
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// 4. Distruggiamo la sessione sul server
session_destroy();

// 5. Reindirizziamo l'utente alla pagina di login
header("Location: login.php");
exit;