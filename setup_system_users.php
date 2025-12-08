<?php
// setup_users.php
global $conn;
require_once "dbConfig.php";

try {
    // A. INSERIAMO I GRUPPI
    // Usiamo IGNORE per non dare errore se i gruppi esistono già
    $conn->exec("INSERT IGNORE INTO gruppo (idGruppo, nome, descrizione) VALUES 
        (1, 'Amministratori', 'Accesso completo: gestione utenti, modifica e cancellazione'),
        (2, 'Standard', 'Accesso limitato: sola visualizzazione')");

    echo "✅ Gruppi creati (o già esistenti).<br>";

    // B. CREIAMO GLI UTENTI
    // 1. Definiamo utenti e password in chiaro
    $adminUser = 'admin';
    $adminPass = 'admin123';

    $stdUser   = 'user';
    $stdPass   = 'user123';

    // 2. Calcoliamo gli HASH sicuri
    $hashAdmin = password_hash($adminPass, PASSWORD_DEFAULT);
    $hashStd   = password_hash($stdPass, PASSWORD_DEFAULT);

    // 3. Prepariamo la query di inserimento
    // Nota: Assegniamo manualmente idGruppo 1 (Admin) e 2 (Standard)
    $sql = "INSERT INTO utenti_sistema (username, password, idGruppo) VALUES 
            (:userA, :passA, 1),
            (:userS, :passS, 2)
            ON DUPLICATE KEY UPDATE password = VALUES(password), idGruppo = VALUES(idGruppo)";

    $stmt = $conn->prepare($sql);
    $stmt->execute([
        ':userA' => $adminUser,
        ':passA' => $hashAdmin,
        ':userS' => $stdUser,
        ':passS' => $hashStd
    ]);

    echo "✅ Utenti creati/aggiornati con successo!<br>";
    echo "<hr>";
    echo "Dati per il login:<br>";
    echo "👮‍♂️ <b>Admin:</b> $adminUser / $adminPass<br>";
    echo "👤 <b>User:</b> $stdUser / $stdPass";

} catch (PDOException $e) {
    die("❌ Errore durante il setup: " . $e->getMessage());
}
?>