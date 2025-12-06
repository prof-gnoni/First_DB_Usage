<?php
require_once "dbConfig.php";
require_once 'myFunctions.php';

// Se dbConfig.php crea $conn fuori da funzioni, 'global' qui è ridondante ma male non fa.
// Assicurati che $conn sia disponibile.
global $conn;

$campi_richiesti = ['nome', 'email', 'genere', 'ddn'];
$errori = [];

// ---------------------------------------------------
// 1. LOGICA DI ELABORAZIONE (Niente HTML qui!)
// ---------------------------------------------------

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // A. Validazione Campi Vuoti
    foreach ($campi_richiesti as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            $errori[] = "Il campo '$campo' è obbligatorio.";
        }
    }

    // B. Recupero Dati (RAW - Senza htmlspecialchars)
    // Usiamo trim() per pulire gli spazi, ma lasciamo i caratteri speciali intatti per il DB
    $nome   = trim($_POST['nome'] ?? '');
    $email  = trim($_POST['email'] ?? '');
    $genere = $_POST['genere'] ?? '';
    $ddn    = $_POST['ddn'] ?? '';

    // C. Validazione Specifica Email
    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errori[] = "L'indirizzo email inserito non è valido.";
    }

    // D. Se non ci sono errori, tentiamo l'inserimento
    if (empty($errori)) {

        $query = "INSERT INTO `utente` (`nome`, `email`, `genere`, `dataNascita`) 
                  VALUES (:nome, :email, :genere, :ddn)";

        try {
            $stmt = $conn->prepare($query);

            $stmt->execute([
                ':nome'   => $nome,
                ':email'  => $email,
                ':genere' => $genere,
                ':ddn'    => $ddn
            ]);

            // SUCCESS! -> Redirect
            // Non stampiamo nulla, rimandiamo l'utente alla home con messaggio di successo
            header("Location: index.php?status=ok");
            exit(); // Stop script immediato

        } catch (PDOException $e) {
            // Log dell'errore reale per lo sviluppatore
            error_log("Errore SQL: " . $e->getMessage());

            // Gestione errore per l'utente
            if ($e->getCode() == 23000) {
                $errori[] = "Questa email risulta già registrata.";
            } else {
                $errori[] = "Errore tecnico nel salvataggio dei dati.";
            }
        }
    }
}

// ---------------------------------------------------
// 2. PRESENTAZIONE (HTML)
// Arriviamo qui SOLO se ci sono errori o se la pagina è chiamata via GET
// ---------------------------------------------------

genera_header("Esito Operazione");
?>

    <div class="container">
        <?php if (!empty($errori)): ?>
            <div style="color: red; border: 1px solid red; padding: 15px; margin: 20px 0;">
                <h3>Si sono verificati degli errori:</h3>
                <ul>
                    <?php foreach ($errori as $errore): ?>
                        <li><?= htmlspecialchars($errore) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p><a href="javascript:history.back()">Torna indietro e correggi</a></p>
            </div>
        <?php else: ?>
            <h1>Accesso diretto non consentito</h1>
            <p>Per favore compila il form dalla home page.</p>
            <a href="index.php">Vai al modulo</a>
        <?php endif; ?>
    </div>

<?php
footer();
?>