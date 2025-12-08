<?php
// myFunctions.php

/**
 * Genera l'intestazione HTML di una pagina.
 *
 * @param string $titolo Il titolo da visualizzare nella barra del browser e nel tag <title>.
 */
function genera_header(string $titolo): void
{
    $titolo_sanificato = htmlspecialchars($titolo);

    // Controlliamo se c'è un utente loggato per mostrare il benvenuto
    $user_panel = "";
    if (isset($_SESSION['username'])) {
        $user = htmlspecialchars($_SESSION['username']);
        // Usiamo 'gruppo' che abbiamo salvato in login.php
        $ruolo = htmlspecialchars($_SESSION['gruppo']);

        // Pannello di benvenuto con tasto Esci (blocco HEREDOC 1)
        $user_panel = <<<PANEL
        <div style="position: absolute; right: 20px; top: 15px; font-size: 0.9rem;">
            👤 <b>$user</b> <span style="opacity:0.7">($ruolo)</span> | 
            <a href="logout.php" style="color: #fff; text-decoration: underline;">Esci</a>
        </div>
PANEL; // <-- ATTENZIONE: Nessuno spazio, solo il marcatore e punto e virgola.
    }

    // Generazione del codice HTML principale (blocco HEREDOC 2)
    echo <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$titolo_sanificato</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header style="position: relative;">
        <h1>$titolo_sanificato</h1>
        $user_panel 
    </header>
    <main>
HTML; // <-- ATTENZIONE: Nessuno spazio, solo il marcatore e punto e virgola.
}

/**
 * Genera la chiusura della pagina HTML.
 */
function footer(): void
{
    // Ottiene l'anno corrente dinamicamente
    $anno_corrente = date('Y');

    echo <<<HTML
    </main>
    <footer>
        <p>&copy; $anno_corrente - Il Tuo Sito Web. Tutti i diritti riservati.</p>
    </footer>
</body>
</html>
HTML;
}