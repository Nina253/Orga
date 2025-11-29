

<!DOCTYPE html>
<html lang="fr">
<head>

    <?php
    include("../bd.php");
    $bdd = getBD();
   ?>
   <?php
session_start();
if(!isset($_SESSION['token'])) {
    $_SESSION['token'] = bin2hex(random_bytes(32));
}
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
    <p class="txt_intro">Ajoute des événements a ton calendrier</p>
    <div class=content>
        <div class="left">
            <?php include 'calendrier.php'; ?>
        </div>
        <div class="right">
        <form id="formulaire_ajout_evt" action="enregistrer_evt.php" method="post">
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">        
        <div>
        <p>Sélectionne la date</p>
        <input type="date" name="date">
        </div>
        <div>
        <p>Titre de l'événement</p>
        <input type="text" name="titre_evt">
        </div>
        <div>
        <p>Déscription de l'événement</p>
        <input type="text" name="description_evt">
        </div>
        <input type="button" value="Ajouter" onclick="publier(event)">
        <div id="message" ></div>
        </form>
        <button class="bouton_retour" onclick="history.back()">Retour</button>
        </div>
          
    </div>
</div>









<footer id="footer_forum">
    <img class="logo" src="../images/logo.png" alt="logo">
    <a href="../nous.php">Qui sommes-nous ?</a>
</footer>



</body>
</html>