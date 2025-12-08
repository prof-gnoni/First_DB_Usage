<?php
// login.php

// 1. Avvio Sessione
global $conn;
session_start();
require_once "myFunctions.php"; // Per l'header e il footer

// 2. Se l'utente è già loggato, lo mandiamo subito alla Home
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header("Location: index.php");
    exit;
}

$errore = "";

// 3. Gestione del Form (quando premi "Accedi")
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "dbConfig.php";

    // Recupero dati input
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';

    try {
        // Query con JOIN per recuperare anche il nome del gruppo
        // Selezioniamo tutti i dati dell'utente (u.*) e il nome del gruppo (g.nome)
        $sql = "SELECT u.*, g.nome AS nome_gruppo 
                FROM utenti_sistema u
                JOIN gruppo g ON u.idGruppo = g.idGruppo
                WHERE u.username = :u";

        $stmt = $conn->prepare($sql);
        $stmt->execute([':u' => $username]);
        $user = $stmt->fetch();

        // Verifica Password
        if ($user && password_verify($password, $user['password'])) {

            // --- LOGIN RIUSCITO ---

            // Impostiamo le variabili di sessione
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['username']  = $user['username'];

            // Salviamo il gruppo: sarà 'Amministratori' o 'Standard'
            // Questo è fondamentale per i controlli in auth_check.php
            $_SESSION['gruppo']    = $user['nome_gruppo'];

            // Redirect alla dashboard
            header("Location: index.php");
            exit;

        } else {
            // Login fallito (password errata o utente non trovato)
            $errore = "Username o Password errati.";
        }

    } catch (PDOException $e) {
        error_log("Errore Login: " . $e->getMessage());
        $errore = "Errore di sistema. Riprova più tardi.";
    }
}

// 4. Generazione Interfaccia
genera_header("Login Sistema");
?>

    <div style="display: flex; justify-content: center; align-items: center; min-height: 60vh;">

        <div style="width: 100%; max-width: 400px; padding: 30px; border: 1px solid #ddd; border-radius: 8px; background-color: #fff; box-shadow: 0 4px 15px rgba(0,0,0,0.1); text-align: center;">

            <h2 style="margin-top: 0; color: #333; margin-bottom: 20px;">🔐 Accesso Richiesto</h2>

            <?php if ($errore): ?>
                <div style="padding: 10px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px;">
                    ⚠️ <?= htmlspecialchars($errore) ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="post">

                <div style="margin-bottom: 15px; text-align: left;">
                    <label for="username" style="font-weight: bold; color: #555;">Username</label>
                    <input type="text" id="username" name="username" placeholder="Inserisci il tuo username" required
                           style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 25px; text-align: left;">
                    <label for="password" style="font-weight: bold; color: #555;">Password</label>
                    <input type="password" id="password" name="password" placeholder="Inserisci la password" required
                           style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
                </div>

                <button type="submit"
                        style="width: 100%; padding: 12px; background-color: #2196F3; color: white; font-size: 1rem; font-weight: bold; border: none; border-radius: 4px; cursor: pointer; transition: background 0.3s;">
                    Accedi
                </button>

            </form>

            <p style="margin-top: 20px; font-size: 0.9rem; color: #666;">
                Non hai le credenziali? Chiedi all'amministratore.
            </p>
        </div>

    </div>

<?php footer(); ?>