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
