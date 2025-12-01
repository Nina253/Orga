

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
        <p>Sélectionne la date:</p>
        <input type="date" name="date">
        </div>
        <div>
        <p>Titre de l'événement:</p>
        <input type="text" name="titre_evt">
        </div>
        <div>
        <p>Déscription de l'événement:</p>
        <textarea name="description_evt"></textarea>
        </div>
        <input class="bouton_bleu" type="button" value="Ajouter" onclick="publier(event)">
        <div id="message" ></div>
        </form>
        </div>
    </div>
</div>
<button class="bouton_retour" onclick="history.back()">Retour</button>









<footer id="footer_forum">
    <img class="logo" src="../images/logo.png" alt="logo">
    <a href="../nous.php">Qui sommes-nous ?</a>
</footer>





<script>
function publier(event) {
    event.preventDefault();

    const form = document.getElementById('formulaire_ajout_evt');
    const formData = new FormData(form);

    fetch('enregistrer_evt.php', {
        method: 'POST',
        body: formData
    })
    .then(async r => {
        const text = await r.text();
        try {
            return JSON.parse(text);
        } catch(e) {
            console.error("Réponse invalide:", text);
            throw e;
        }
    })
    .then(data => {
        const messageDiv = document.getElementById('message');
        if(data.success){
            messageDiv.innerHTML = "<span style='color:green;'>Événement ajouté !</span>";
            form.reset();
        } else {
            messageDiv.innerHTML = "<span style='color:red;'>Erreur : " + (data.error || "Inconnue") + "</span>";
        }
    })
    .catch(err => {
        console.error(err);
        document.getElementById('message').innerHTML = "<span style='color:red;'>Erreur serveur</span>";
    });
}
</script>

</body>
</html>