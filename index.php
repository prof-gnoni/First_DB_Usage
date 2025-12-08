<?php
// index.php

// 1. SICUREZZA: Controllo accesso e avvio sessione
require_once "auth_check.php";

// 2. Connessione e Funzioni
global $conn;
require_once "dbConfig.php";
require_once "myFunctions.php";

// 3. LOGICA MESSAGGI (NEW: Legge da SESSIONE e CANCELLA)
$messaggio_html = "";
// Verifichiamo se esiste una chiave 'status' in SESSIONE
if (isset($_SESSION['status'])) {
    $status = $_SESSION['status'];

    if ($status === 'ok') {
        $messaggio_html = '<div id="messaggio" class="msg-box msg-success">✅ Utente registrato con successo!</div>';
    } elseif ($status === 'deleted') {
        $messaggio_html = '<div id="messaggio" class="msg-box msg-deleted">🗑️ Utente eliminato con successo.</div>';
    } elseif ($status === 'updated') {
        $messaggio_html = '<div id="messaggio" class="msg-box msg-updated">✏️ Utente aggiornato con successo.</div>';
    }

    // QUESTO È IL PASSAGGIO CRUCIALE: Rimuoviamo il messaggio subito dopo averlo letto.
    unset($_SESSION['status']);
}

// 4. RECUPERO DATI (SELECT)
$lista_utenti = [];
try {
    // Ordiniamo per ID decrescente così vediamo subito gli ultimi inseriti
    $stmt = $conn->query("SELECT * FROM utente ORDER BY idUtente DESC");
    $lista_utenti = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Errore lettura index: " . $e->getMessage());
}

// 5. GENERAZIONE PAGINA
genera_header("Gestione Utenti");
?>

<?= $messaggio_html ?>

    <div style="display: flex; flex-wrap: wrap; gap: 40px; justify-content: center;">

        <?php if (isAdmin()): ?>
            <section id="form-section" style="flex: 1; min-width: 300px; max-width: 400px; background: #fff; padding: 20px; border: 1px solid #ddd; border-radius: 8px; height: fit-content;">
                <h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #4CAF50; padding-bottom: 10px;">
                    ➕ Nuovo Utente
                </h3>

                <form action="modulo_utente_action_page.php" method="post">
                    <label for="nome">Nome:</label><br>
                    <input type="text" id="nome" name="nome" placeholder="Es. Mario Rossi" required style="width: 100%; padding: 8px; margin: 5px 0 15px; box-sizing: border-box;"><br>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" placeholder="email@esempio.com" required style="width: 100%; padding: 8px; margin: 5px 0 15px; box-sizing: border-box;"><br>

                    <label>Genere:</label><br>
                    <div style="margin: 5px 0 15px;">
                        <input type="radio" id="uomo" name="genere" value="uomo" checked> <label for="uomo">Uomo</label>
                        <input type="radio" id="donna" name="genere" value="donna"> <label for="donna">Donna</label>
                    </div>

                    <label for="ddn">Data di nascita:</label><br>
                    <input type="date" id="ddn" name="ddn" style="width: 100%; padding: 8px; margin: 5px 0 15px; box-sizing: border-box;"><br>

                    <input type="submit" name="btnSubmit" value="Registra Utente"
                           style="background-color: #4CAF50; color: white; padding: 10px 15px; border: none; cursor: pointer; width: 100%; font-size: 1rem;">
                </form>
            </section>
        <?php endif; ?>

        <section id="lista-utenti" style="flex: 2; min-width: 400px;">
            <h3 style="margin-top: 0; color: #333; border-bottom: 2px solid #2196F3; padding-bottom: 10px;">
                👥 Elenco Iscritti (<?= count($lista_utenti) ?>)
            </h3>

            <?php if (count($lista_utenti) > 0): ?>
                <table>
                    <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Genere</th>
                        <th>Data Nascita</th>

                        <?php if (isAdmin()): ?>
                            <th style="width: 120px; text-align: center;">Azioni</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($lista_utenti as $utente): ?>
                        <?php
                        // Gestione data
                        $data_db = $utente['dataNascita'];
                        $data_it = !empty($data_db) ? date("d/m/Y", strtotime($data_db)) : "-"; // Spiegato prima!
                        ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($utente['nome']) ?></strong></td>
                            <td><?= htmlspecialchars($utente['email']) ?></td>
                            <td><?= htmlspecialchars($utente['genere']) ?></td>
                            <td><?= $data_it ?></td>

                            <?php if (isAdmin()): ?>
                                <td style="text-align: center; white-space: nowrap;">
                                    <a href="update.php?id=<?= $utente['idUtente'] ?>"
                                       class="btn-action btn-edit" title="Modifica">
                                        ✏️
                                    </a>

                                    <a href="delete.php?id=<?= $utente['idUtente'] ?>"
                                       class="btn-action btn-delete"
                                       onclick="return confirm('Sei sicuro di voler eliminare <?= htmlspecialchars($utente['nome']) ?>?');" title="Elimina">
                                        🗑️
                                    </a>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div style="padding: 20px; background-color: #f8f9fa; border: 1px solid #ddd; border-left: 4px solid #2196F3;">
                    <p>ℹ️ <strong>Nessun utente trovato.</strong></p>
                    <?php if (isAdmin()): ?>
                        <p>Usa il modulo a sinistra per aggiungere il primo!</p>
                    <?php else: ?>
                        <p>Contatta l'amministratore per maggiori informazioni.</p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </section>

    </div>

    <script>
        // Script per far sparire i messaggi dopo 4 secondi in modo fluido
        document.addEventListener("DOMContentLoaded", function() {

            /** @type {HTMLElement} */ // Per placare l'IDE
            let box = document.getElementById('messaggio');

            if (box) {
                // Dopo 4 secondi, iniziamo la sequenza di scomparsa
                setTimeout(function() {

                    // FASE 1: Fade-out dell'opacità (1 secondo)
                    box.style.opacity = "0";

                    // FASE 2: Collasso verticale (inizia dopo 1 secondo di fade)
                    setTimeout(function() {

                        // PASSO 2A: LEGGI E IMPOSTA L'ALTEZZA ESPLICITA (es. 70px)
                        // Questo prepara l'elemento per la transizione CSS
                        box.style.height = box.offsetHeight + 'px';

                        // PASSO 2B: Piccolo ritardo (50ms) per forzare il browser a leggere l'altezza prima di cambiarla
                        setTimeout(function() {
                            // PASSO 2C: Settiamo i valori finali a zero per attivare il collasso CSS
                            box.style.padding = '0';
                            box.style.marginBottom = '0';
                            box.style.border = 'none';
                            box.style.height = '0'; // Il collasso avviene qui!

                            // FASE 3: Rimozione completa (dopo 0.5 secondi di collasso)
                            setTimeout(function() {
                                box.style.display = 'none';
                            }, 500);

                        }, 50); // 50ms di ritardo per il browser

                    }, 1000); // 1 secondo (aspetta che l'opacità sia a zero)
                }, 4000); // Inizia dopo 4 secondi totali
            }
        });
    </script>

<?php footer(); ?>