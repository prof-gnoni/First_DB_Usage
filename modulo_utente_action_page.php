<?php
global $conn;
require_once "dbconfig.php";
require_once 'myFunctions.php';

// Array con i nomi dei campi che ti aspetti di ricevere
$campi_richiesti = ['nome', 'email', 'genere','ddn'];

// Array per raccogliere gli errori
$errori = [];

genera_header("Ricezione Dati");
// Controlla se il metodo di richiesta è POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    foreach ($campi_richiesti as $campo) {
        // Verifica se il campo non è stato inviato o se è vuoto
        // Usiamo trim() per rimuovere spazi bianchi all'inizio e alla fine
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            $errori[] = "Il campo '{$campo}' è obbligatorio.";
        }
    }

    // Se l'array degli errori è vuoto, tutti i dati sono validi
    if ( empty($errori) ) {
        echo "<p>Tutti i campi richiesti sono presenti e validi.</p>";
        // Procedi con l'elaborazione...
        $nome = htmlspecialchars($_POST['nome']);
        $email = htmlspecialchars($_POST['email']);
        $genere = htmlspecialchars($_POST['genere']);
        $ddn = htmlspecialchars($_POST['ddn']);
        // $messaggio = htmlspecialchars($_POST['messaggio']);
        //$messaggio = $_POST['messaggio'];
        // $interesse = htmlspecialchars($_POST['interesse']);
        // $newsletter = htmlspecialchars($_POST['newsletter']);

        echo $nome;
        echo "<br>";
        echo $genere;
        echo "<br>";
        echo $ddn;
        echo "<br>";
        echo $email;
        echo "<br>";

        echo "<br>";
        // echo $_POST['btnSubmit'];

        $query="INSERT INTO utente (nome, email, genere, dataNascita) VALUES ('$nome','$email','$genere','$ddn');";
        echo "<br>";
        echo $query;

        $conn->exec($query);


    } else {
        echo "Si sono verificati i seguenti errori:<br>";
        // Mostra tutti gli errori trovati
        foreach ($errori as $errore) {
            echo "- " . $errore . "<br>";
        }
    }
} else {
    // Messaggio per l'utente
    echo "<h1>Accesso non consentito</h1>";
    echo "<p>Questa pagina serve per elaborare i dati di un modulo.</p>";
    echo "<p>Per favore, compila il modulo partendo da questa pagina:</p>";
    echo '<a href="index.php" title="Vai alla compilazione del modulo">Torna al modulo</a>';
}
footer();