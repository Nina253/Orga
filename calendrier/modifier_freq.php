

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
    <p class="txt_intro">Modifie la fréquence des rappels pour remplir le questionnaire</p>
    <div class=content>
        <div class="left">
            <?php include 'calendrier.php'; ?>
        </div>
        <div class="right">
        <form id="formulaire_ajout_evt" action="enregistrer_evt.php" method="post">
        <legend class="ajt_evt">Modifier la fréquence</legend>
        <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">        
        <div>
        <p>Sélectionne la date de début</p>
        <input type="date" name="date">
        </div>
        <div class>
        <p>Coche la nouvelle fréquence souhaitée:</p>
        <div id="coche">
  <div class="radio-container">
    <input type="radio" id="quoti" name="nouv_freq" value="0">
    <label for="quoti">Quotidienne (tous les jours)</label>
  </div>
  <div class="radio-container">
    <input type="radio" id="hebdo" name="nouv_freq" value="1">
    <label for="hebdo">Hebdomadaire (toutes les semaines)</label>
  </div>
  <div class="radio-container">
    <input type="radio" id="mens" name="nouv_freq" value="2">
    <label for="mens">Mensuelle (tous les mois)</label>
  </div>
</div>
    </div>
        
        <input id="btn_modif_cal" class="bouton_bleu" type="button" value="Modifier" onclick="publier(event)">
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

    // On envoie les données à PHP pour mise à jour
    fetch('modifier_freq_evt.php', {
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
            messageDiv.innerHTML = "<span style='color:green;'>Fréquence mise à jour !</span>";
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