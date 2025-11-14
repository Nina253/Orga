<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include("bd.php");
    $bdd = getBD();
    if (!isset($_SESSION['token'])) {
			$_SESSION['token'] = bin2hex(random_bytes(32));
			}

      
    ?>
    
    
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    let validTitre = false;
    let validText=false;
    $(document).ready(function()){
        function validationTitre(val){
            val=val.trim();
            return typeof val=="string" && val.length>1;
        }
        function validationText(val){
            val=val.trim();
            return typeof val=="string" && val.length>20;
        }
    }
    function publier(event) {
    event.preventDefault();
    let formData = $('#formulaire_nouveau_sujet').serialize(); // récupère titre + contenu + token
    $.ajax({
        url: 'enregistrer_sujet.php',
        type: 'POST',
        data: formData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                $('#message').css({'color':'green'}).text(response.message);
                // Redirection après 1 seconde
                setTimeout(function() {
                    window.location.href='forum.php';
                }, 1000);
            } else {
                $('#message').css({'color':'red'}).text(response.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            $('#message').css({'color':'red'}).text("Erreur serveur : " + textStatus);
            console.error(jqXHR.responseText);
        }
    });
}
    </script>

    <title>Nouveau sujet</title>

</head>
<body>
    <?php include "navbar.php";?>
    <h1>Nouveau sujet</h1>
    <p class="txt_intro">Pose ta question</p>

    <form id="formulaire_nouveau_sujet" action="enregistrer_sujet.php" method="post">
    <input type="hidden" name="token" value="<?php echo $_SESSION['token']; ?>">
    <p>Titre</p>
    <input type="text" name="titre">
    <p>Contenu</p>
    <textarea id="contenu" name="contenu" rows="6" required></textarea><br><br>
	<input type="button" value="Publier" onclick="publier(event)">
    <div id="message" ></div>
    </form>
    


   

</body>
</html>