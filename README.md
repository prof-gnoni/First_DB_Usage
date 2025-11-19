# 📘 Sistema di Registrazione Utenti (PHP & MariaDB)

Un'applicazione web leggera e sicura per la gestione di utenti, sviluppata in **PHP nativo** seguendo le moderne best practices di sviluppo (PDO, Prepared Statements, MVC-like structure).

![PHP](https://img.shields.io/badge/PHP-8.0%2B-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MariaDB](https://img.shields.io/badge/MariaDB-10.6%2B-003545?style=for-the-badge&logo=mariadb&logoColor=white)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)
![Status](https://img.shields.io/badge/Status-Production%20Ready-success?style=for-the-badge)

## ✨ Funzionalità Principali

* **Sicurezza First:** Utilizzo di **PDO** con **Prepared Statements** per prevenire SQL Injection.
* **Gestione Errori:** Sistema robusto di `try/catch` con logging degli errori lato server e messaggi user-friendly lato client.
* **Validazione Dati:** Controllo lato server degli input (email valida, campi obbligatori, trimming).
* **UX Moderna:**
    * Feedback visivi a scomparsa automatica (JavaScript puro).
    * Tabelle responsive e stilizzate CSS.
    * Formattazione date italiana (dd/mm/yyyy).
* **Codice Pulito:** Separazione tra logica di business (PHP), struttura (HTML) e presentazione (CSS).

---

## 📂 Struttura del Progetto

```text
.
├── database/
│   └── first_db_usage.sql       # Dump SQL per creare il DB e la tabella
├── index.php                    # Home page (Form inserimento + Lista utenti)
├── modulo_utente_action_page.php # Logica di backend (Validazione e Insert)
├── dbConfig.php                 # Parametri di connessione al Database
├── myFunctions.php              # Libreria di funzioni (Header, Footer, HTML helpers)
├── main.js                      # Script JS (caricato con defer) per UI
├── .gitignore                   # File esclusi da Git
└── README.md                    # Documentazione del progetto

🚀 Installazione e Configurazione
Segui questi passaggi per avviare il progetto in locale.

1. Prerequisiti
Assicurati di avere installato:

Un server web (Apache/Nginx) o ambiente locale (XAMPP, MAMP, Docker).

PHP 7.4 o superiore.

MariaDB o MySQL.

2. Setup del Database
Il file SQL per la creazione della struttura si trova nella cartella database/.

Accedi al tuo client database (phpMyAdmin, DBeaver, Terminale).

Importa il file database/first_db_usage.sql.

Oppure via terminale (dalla root del progetto):

Bash
mysql -u root -p < database/first_db_usage.sql

3. Configurazione Connessione
Apri il file dbConfig.php e modifica i parametri in base al tuo ambiente.

Nota importante per utenti macOS (MAMP/XAMPP): Se riscontri errori di connessione TCP o socket, usa 127.0.0.1 invece di localhost.

PHP
$host = "127.0.0.1"; // Usa IP per forzare connessione TCP su Unix/Mac
$port = 3306;        // MAMP usa 8889, XAMPP/Standard usa 3306
$user = "root";
$pass = "";          // Su MAMP solitamente è 'root'
$db   = "first_db_usage";

4. Avvio
Posizionati nella cartella del progetto e avvia il server locale. Se usi il terminale integrato di PHP:

Bash
php -S localhost:8000

Apri il browser su http://localhost:8000.

🧠 Dettagli Tecnici
Pattern PRG (Post-Redirect-Get)
Dopo l'invio del form, l'applicazione esegue un redirect per evitare il reinvio accidentale dei dati (il classico avviso "Conferma reinvio modulo" del browser) e fornisce un feedback visivo tramite query string (?status=ok).

PHP
header("Location: index.php?status=ok");
exit();

Performance JavaScript (Defer)
Lo script main.js viene caricato utilizzando l'attributo defer nell'head. Questo garantisce che lo script venga scaricato in parallelo ma eseguito solo dopo che il DOM è completamente costruito, eliminando la necessità di DOMContentLoaded o jQuery. (QUESTO È ANCORA DA FARE)

🛠 Troubleshooting (Problemi comuni)
Errore "Connection Refused": Controlla che la porta in dbConfig.php corrisponda a quella del tuo server MariaDB/MySQL.

Errore "No such file or directory" (Mac): Cambia $host da localhost a 127.0.0.1.

Il messaggio verde non sparisce: Verifica che il file main.js sia nella stessa cartella di index.php e che il browser non stia usando una versione in cache (prova CTRL+F5).

📝 Autore
Sviluppato da [Emanuele] come progetto di studio per l'interazione avanzata PHP-MariaDB.
