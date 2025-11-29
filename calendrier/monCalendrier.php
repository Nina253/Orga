

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php
    include("../bd.php");
    $bdd = getBD();
   ?>
   <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
   
    <title>Mon Calendrier</title>
</head>
<body>
    <?php include "../navbar.php" ?>
    <div class="container">
   
    <h1>Mon calendrier</h1>
    <p class="txt_intro">Voici un aperçu de ce que tu as a faire aujourd’hui</p>
    <div class=content>
        <div class="left">
            <?php include 'calendrier.php'; ?>
        </div>

        <div class="right">
            <div class="today-info">
            <h3 id="selected-date-title">Aucune date sélectionnée</h3>
            <ul id="event-list">
                <li>enregistre tes habitudes</li>
                <li>autres tâches programmées</li>
            </ul>
            </div>
            <a class="bouton_retour" href="ajouter_evt.php">Ajoute des événements a ton calendrier</a>
            <a class="bouton_retour" href="modifier_freq.php">Modifie la fréquence de tes enregistrements</a>
    </div>
</div>









<footer id="footer_forum">
    <img class="logo" src="../images/logo.png" alt="logo">
    <a href="../nous.php">Qui sommes-nous ?</a>
</footer>



</body>
</html>