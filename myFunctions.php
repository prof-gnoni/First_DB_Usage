<?php

/**
 * Genera l'intestazione HTML di una pagina.
 *
 * @param string $titolo Il titolo da visualizzare nella barra del browser e nel tag <title>.
 */
function genera_header(string $titolo): void
{
    // Usiamo htmlspecialchars() per sicurezza, nel caso il titolo contenga caratteri speciali.
    $titolo_sanificato = htmlspecialchars($titolo);

    echo <<<HTML
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>$titolo_sanificato</title>
    <style>
    /* Stile per la Tabella */
    table {
        width: 100%;
        max-width: 900px;           /* Come deciso prima */
        margin: 20px auto;          /* Centrata */
        border-collapse: collapse;  /* Fonde i bordi (essenziale per sostituire border="1") */
        border: 1px solid #ddd;     /* Bordo esterno sottile */
    }

    /* Stile per le Celle (Sostituisce border="1" e cellpadding="10") */
    th, td {
        border: 1px solid #ddd; /* Il bordo di ogni cella */
        padding: 10px;          /* IL CELLPADDING: spazio interno */
        text-align: left;       /* Allinea il testo a sinistra (opzionale) */
    }

    /* Un tocco in più: stile per l'intestazione */
    th {
        background-color: #f2f2f2; /* Sfondo grigino per l'intestazione */
        font-weight: bold;
    }
    /* Effetto Hover sulle righe della tabella */
    tr:hover {
        background-color: #f5f5f5; /* Grigio chiarissimo */
        cursor: pointer;           /* Cambia il cursore in una manina (opzionale) */
    }
    
    /* Manteniamo l'intestazione ferma (non deve cambiare colore) */
    thead tr:hover {
        background-color: transparent; /* O il colore di sfondo originale dell'intestazione */
        cursor: default;
    }
    /* Stile per il Footer */
    footer {
        text-align: center;      /* 1. Centra il testo orizzontalmente */
        padding: 20px 0;         /* 2. Aggiunge spazio sopra e sotto il testo */
        margin-top: 40px;        /* 3. Lo spinge giù, staccandolo dalla tabella/form */
        border-top: 1px solid #ddd; /* 4. (Opzionale) Una linea sottile di separazione */
        font-size: 0.9em;        /* 5. (Opzionale) Testo leggermente più piccolo */
        color: #666;             /* 6. (Opzionale) Colore grigio scuro, meno "pesante" del nero */
    }
    </style>
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