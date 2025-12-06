<?php

/**
 * Genera l'intestazione HTML di una pagina.
 *
 * @param string $titolo Il titolo da visualizzare nella barra del browser e nel tag <title>.
 */
function genera_header(string $titolo): void
{
    $titolo_sanificato = htmlspecialchars($titolo);

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
    <header>
        <h1>$titolo_sanificato</h1>
    </header>
    <main>

HTML;
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