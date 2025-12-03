<?php 
	session_start();
    if (!isset($_SESSION['client'])){
        header('Location: home.php');
        exit;
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 

    <title>Mon compte</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">

    <div class="profile">
        <img src="<?php echo $_SESSION['client']['url']?>" alt="perso">
        <h1 id="hcompte" style='font-family: "Montserrat"'>Bienvenue <?php echo$_SESSION['prenom']; ?></h1>
        
    </div>
        <p id="qstf" class="subtitle">Que souhaites-tu faire ?</p>

    <div class="content">
        
        <div class="left">
            
            <div id="boutons_compte">
            <a href="tableau_de_bord/tableau_bord.php"> <div class='bloc'>  Accéder à mon tableau de bord </div> </a>
            <a href="questionnaire/questionnaire_v2.php"><div class='bloc'>  Faire le questionnaire </div></a>
            <a href="calendrier/moncalendrier.php"><div class='bloc'>  Accéder à mon calendrier </div></a>
            <a href="forum/forum.php"><div class='bloc'>  Accéder au forum </div></a>
            <a href="forum/mesSujets.php"> <div class='bloc'> Accéder à mes articles publiés dans le forum</div></a>
            <a href="profil/profil.php"><div class='bloc'>  Accéder / Modifier mes données personnelles </div></a>
            </div>
        </div>
        <div class="right">
            <?php include 'calendrier/calendrier.php'; ?>
        </div>

    </div>

</div>
<br></br>
<br>
<button class="bouton_retour" onclick="history.back()">Retour</button>
<?php include "navbarBas.php" ?>
</body>
</html>
