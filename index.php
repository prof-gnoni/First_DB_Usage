<?php
require_once "dbconfig.php";
require_once "myFunctions.php";

genera_header("Home Page");
?>
<section id="form">
    <h3>Modulo di Contatto</h3>
    <p>I moduli sono fondamentali per l'interazione con l'utente.</p>
    <form action="modulo_utente_action_page.php" method="post">
        <fieldset>
            <legend>Informazioni Personali</legend>

            <label for="nome">Nome:</label><br>
            <input type="text" id="nome" name="nome" placeholder="Es. Mario Rossi" <?php //required?> autofocus><br><br>

            <label for="email">Email:</label><br>
            <input type="email" id="email" name="email" <?php //required?>><br><br>
            <?php
            /*

            <label for="messaggio">Messaggio:</label><br>
            <textarea id="messaggio" name="messaggio" rows="4" cols="50" <?php //required?>></textarea><br><br>
            */
            ?>
            <label>Genere:</label><br>
            <input type="radio" id="uomo" name="genere" value="uomo" <?php //required?>>
            <label for="uomo">Uomo</label>
            <input type="radio" id="donna" name="genere" value="donna">
            <label for="donna">Donna</label><br><br>

            <label for="ddn">Data di nascita:</label><br>
            <input type="date" id="ddn" name="ddn" <?php //required?>><br><br>
            <?php
            /*

            <label for="interesse">Argomento di interesse:</label><br>
            <select id="interesse" name="interesse" <?php //required?>>
                <option id="noselect" value="" selected></option>
                <option value="tecnologia">Tecnologia</option>
                <option value="arte">Arte</option>
                <option value="sport">Sport</option>
            </select><br><br>

            <input type="checkbox" id="newsletter" name="newsletter" value="pippo">
            <label for="newsletter">Iscrivimi alla newsletter</label><br><br>
            */
            ?>
            <input type="submit" name="btnSubmit" value="Invia Modulo">
            <input type="reset" value="Annulla">
        </fieldset>
    </form>
</section>

<?php footer(); ?>