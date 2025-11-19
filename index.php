<?php
// 1. De-commentiamo la connessione perché vogliamo leggere i dati dal DB
global $conn;
require_once "dbConfig.php";
require_once "myFunctions.php";

// 2. LOGICA PER MESSAGGIO DI SUCCESSO
// Controlliamo se nell'URL c'è ?status=ok
$messaggio_successo = "";
if (isset($_GET['status']) && $_GET['status'] === 'ok') {
    $messaggio_successo = "✅ Utente registrato con successo!";
}

// 3. LOGICA PER RECUPERARE GLI UTENTI (SELECT)
// Vogliamo mostrare la lista degli iscritti sotto il form
$lista_utenti = [];
try {
    // Usiamo query() perché non abbiamo parametri esterni (niente WHERE variabile)
    // Assumo che la tua tabella abbia un campo id autoincrement, altrimenti ordina per nome
    $stmt = $conn->query("SELECT * FROM utente ORDER BY nome");
    $lista_utenti = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Errore lettura index: " . $e->getMessage());
    // Non blocchiamo la pagina se la lettura fallisce, semplicemente la lista sarà vuota
}

genera_header("Home Page");
?>

<?php if ($messaggio_successo): ?>
    <div id="messaggio-successo" style="background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; padding: 15px; margin-bottom: 20px; border-radius: 4px;">
        <strong><?= $messaggio_successo ?></strong>
    </div>
<?php endif; ?>

    <section id="form">
        <h3>Modulo di Contatto</h3>
        <p>I moduli sono fondamentali per l'interazione con l'utente.</p>

        <form action="modulo_utente_action_page.php" method="post">
            <fieldset>
                <legend>Informazioni Personali</legend>

                <label for="nome">Nome:</label><br>
                <input type="text" id="nome" name="nome" placeholder="Es. Mario Rossi" autofocus><br><br>

                <label for="email">Email:</label><br>
                <input type="email" id="email" name="email"><br><br>

                <label>Genere:</label><br>
                <input type="radio" id="uomo" name="genere" value="uomo">
                <label for="uomo">Uomo</label>
                <input type="radio" id="donna" name="genere" value="donna">
                <label for="donna">Donna</label><br><br>

                <label for="ddn">Data di nascita:</label><br>
                <input type="date" id="ddn" name="ddn"><br><br>

                <input type="submit" name="btnSubmit" value="Invia Modulo">
                <input type="reset" value="Annulla">
            </fieldset>
        </form>
    </section>

    <hr>

    <section id="lista-utenti">
        <h3>Utenti Registrati</h3>

        <?php if (count($lista_utenti) > 0): ?>

            <table style="border-collapse: collapse; border: 1px solid #ddd; width: 100%; max-width: 900px; margin: 20px auto;">
                <thead>
                <tr style="background-color: #f2f2f2; text-align: left;">
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Genere</th>
                    <th>Data di Nascita</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($lista_utenti as $utente): ?>
                    <?php
                    // TRASFORMAZIONE DATA
                    // 1. Prendo la data dal DB (es. "2023-11-15")
                    $data_grezza = $utente['dataNascita'];

                    // 2. Controllo se la data esiste (non è null o vuota)
                    if (!empty($data_grezza)) {
                        // strtotime converte la stringa in un timestamp numerico
                        // date ricostruisce la stringa nel formato Giorno/Mese/Anno
                        $data_italiana = date("d/m/Y", strtotime($data_grezza));
                    } else {
                        $data_italiana = "-"; // Se manca la data
                    }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($utente['nome']) ?></td>
                        <td><?= htmlspecialchars($utente['email']) ?></td>
                        <td><?= htmlspecialchars($utente['genere']) ?></td>
                        <td><?= $data_italiana ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>

        <?php else: ?>

            <div style="padding: 20px; background-color: #f8f9fa; border: 1px solid #ddd; color: #666;">
                <p>ℹ️ <strong>Nessun utente registrato.</strong></p>
                <p>Compila il modulo qui sopra per aggiungere il primo utente!</p>
            </div>

        <?php endif; ?>
    </section>

    <script>
        // Aspetta che la pagina sia caricata
        document.addEventListener("DOMContentLoaded", function() {

            // Cerca l'elemento con l'ID specifico
            /** @type {HTMLElement} */
            let boxMessaggio = document.getElementById('messaggio-successo');

            // Se l'elemento esiste (quindi se c'è stato un messaggio di successo)
            if (boxMessaggio) {

                // Imposta un timer di 5000 millisecondi (5 secondi)
                setTimeout(function() {

                    // Opzione A: Sparizione secca
                    // boxMessaggio.style.display = 'none';

                    // Opzione B (Più elegante): Se vuoi che svanisca piano, usa questa logica:
                    boxMessaggio.style.transition = "opacity 1s ease-out";
                    boxMessaggio.style.opacity = "0";
                    setTimeout(function() { boxMessaggio.style.display = 'none'; }, 1000);
                }, 5000);
            }
        });
    </script>

<?php footer(); ?>