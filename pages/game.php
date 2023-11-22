<?php
session_start();

include_once '../function/gestionBD.inc.php';

include '../function/functions.php';


?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Partie</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/styles.css">
    <script defer src="../script/game.js"></script>
</head>

<body>
    <section class="debut_partie">
        <h2 class="titre_questionnaire">Questionnaire de Culture Générale</h2>
        <p>C'est Parti !</p>
    </section>
    <section class="une_question cacher">
        <h3 class="question"></h3>
        <ul class="reponses">
        </ul>
    </section>
    <section class="suivant cacher">
        <p>suivant</p>
    </section>
    <section class='fin cacher'>
        <h3 class='question'>Fin du test</h3>
        <p>Fermer</p>
        
    </section>
</body>

</html>