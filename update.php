<?php
// update.php
global $conn;
require_once "dbConfig.php";
require_once "myFunctions.php";

// 1. CONTROLLO INIZIALE ID
// Se non c'è l'id nell'URL, lo rispediamo alla home
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$errore = "";

// 2. GESTIONE DEL SALVATAGGIO (Quando si preme "Salva Modifiche")
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperiamo i dati dal form
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $genere = $_POST['genere'] ?? '';
    $ddn = $_POST['ddn'] ?? '';
    $id_utente = $_POST['id'] ?? ''; // L'ID nascosto

    // Validazione minima
    if (empty($nome) || empty($email)) {
        $errore = "Attenzione: Nome ed Email sono obbligatori.";
    } else {
        try {
            // Query di aggiornamento (Update)
            // Nota: usiamo i placeholder :nome, :email ecc. per sicurezza
            $sql = "UPDATE utente 
                    SET nome = :nome, 
                        email = :email, 
                        genere = :genere, 
                        dataNascita = :ddn 
                    WHERE idUtente = :id";

            $stmt = $conn->prepare($sql);
            $stmt->execute([
                    ':nome' => $nome,
                    ':email' => $email,
                    ':genere' => $genere,
                    ':ddn' => $ddn,
                    ':id' => $id_utente
            ]);

            // Se tutto va bene, torniamo alla lista con messaggio di successo
            header("Location: index.php?status=updated");
            exit;

        } catch (PDOException $e) {
            $errore = "Errore durante il salvataggio: " . $e->getMessage();
        }
    }
}

// 3. RECUPERO DATI UTENTE (Per riempire il form)
// Questo avviene quando apri la pagina la prima volta
$utente = [];
try {
    $stmt = $conn->prepare("SELECT * FROM utente WHERE idUtente = :id");
    $stmt->execute([':id' => $id]);
    $utente = $stmt->fetch(); // Fetch come Array Associativo (default)

    if (!$utente) {
        die("Utente non trovato.");
    }
} catch (PDOException $e) {
    die("Errore di connessione: " . $e->getMessage());
}

// 4. GENERAZIONE INTERFACCIA
genera_header("Modifica Utente");
?>

    <div style="max-width: 500px; margin: 40px auto; background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">

        <h2 style="margin-top: 0; border-bottom: 2px solid #2196F3; padding-bottom: 10px; color: #333;">
            ✏️ Modifica Utente
        </h2>

        <?php if ($errore): ?>
            <div style="padding: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 4px; margin-bottom: 20px;">
                <?= $errore ?>
            </div>
        <?php endif; ?>

        <form action="update.php?id=<?= $utente['idUtente'] ?>" method="post">

            <input type="hidden" name="id" value="<?= $utente['idUtente'] ?>">

            <label for="nome" style="font-weight: bold; display: block; margin-bottom: 5px;">Nome:</label>
            <input type="text" id="nome" name="nome"
                   value="<?= htmlspecialchars($utente['nome']) ?>"
                   required
                   style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">

            <label for="email" style="font-weight: bold; display: block; margin-bottom: 5px;">Email:</label>
            <input type="email" id="email" name="email"
                   value="<?= htmlspecialchars($utente['email']) ?>"
                   required
                   style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">

            <label style="font-weight: bold; display: block; margin-bottom: 5px;">Genere:</label>
            <div style="margin-bottom: 20px;">
                <input type="radio" id="uomo" name="genere" value="uomo"
                        <?= ($utente['genere'] == 'uomo') ? 'checked' : '' ?>>
                <label for="uomo" style="margin-right: 15px;">Uomo</label>

                <input type="radio" id="donna" name="genere" value="donna"
                        <?= ($utente['genere'] == 'donna') ? 'checked' : '' ?>>
                <label for="donna">Donna</label>
            </div>

            <label for="ddn" style="font-weight: bold; display: block; margin-bottom: 5px;">Data di nascita:</label>
            <input type="date" id="ddn" name="ddn"
                   value="<?= $utente['dataNascita'] ?>"
                   style="width: 100%; padding: 10px; margin-bottom: 30px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">

            <div style="display: flex; gap: 10px;">
                <input type="submit" value="Salva Modifiche"
                       style="flex: 1; background-color: #2196F3; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 1rem; font-weight: bold; transition: background 0.3s;">

                <a href="index.php"
                   style="flex: 1; text-align: center; background-color: #ddd; color: #333; padding: 12px; text-decoration: none; border-radius: 4px; font-weight: bold; transition: background 0.3s;">
                    Annulla
                </a>
            </div>

        </form>
    </div>

<?php footer(); ?>