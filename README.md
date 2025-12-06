# 📘 Gestione Utenti CRUD (PHP & MariaDB)

Un'applicazione web completa per la gestione di utenti, sviluppata in **PHP nativo** seguendo le moderne best practices di sviluppo (PDO, Prepared Statements, Separation of Concerns).
Il progetto è stato esteso da un semplice form di registrazione a un sistema **CRUD completo** (Create, Read, Update, Delete).

## ✨ Funzionalità Principali

* **Sicurezza First:** Utilizzo di **PDO** con **Prepared Statements** per prevenire SQL Injection ovunque.
* **CRUD Completo:**
    * **Create:** Registrazione nuovi utenti con validazione.
    * **Read:** Visualizzazione lista utenti ordinata.
    * **Update:** Modifica dati con pre-compilazione del form (*Sticky Forms*).
    * **Delete:** Eliminazione sicura con conferma preventiva.
* **UX Moderna:**
    * Layout Dashboard con Flexbox (Form e Tabella affiancati).
    * Pulsanti animati con transizioni CSS fluide (effetto "lift").
    * Feedback visivi a scomparsa automatica (JavaScript).
    * Formattazione date italiana (dd/mm/yyyy).
* **Codice Pulito:** Separazione tra logica di business (PHP), struttura (HTML) e presentazione (CSS esterno).

## 📂 Struttura del Progetto

```text
.
├── database/
│   └── first_db_usage.sql        # Dump SQL per creare il DB e la tabella
├── index.php                     # Dashboard: Form inserimento + Lista utenti
├── update.php                    # Pagina di modifica utente (Self-processing)
├── delete.php                    # Script di eliminazione (Action Page)
├── modulo_utente_action_page.php # Logica di inserimento (Action Page)
├── dbConfig.php                  # Parametri di connessione al Database
├── myFunctions.php               # Libreria di funzioni (Header, Footer, Helpers)
├── style.css                     # Foglio di stile CSS (Layout e Design)
├── .gitignore                    # File esclusi da Git
└── README.md                     # Documentazione del progetto
