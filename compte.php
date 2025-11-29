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
        <h1 id="hcompte" style='font-family: "Montserrat"'>Bienvenue <?echo $_SESSION['prenom'];?></h1>
        <p class="subtitle">Que souhaites-tu faire ?</p>
    </div>

    <div class="content">

        <div class="left">
            <div class='bloc'>  <a href="tableau_de_bord/tableau_bord.php">Accéder à mon tableau de bord</a> </div>
            <div class='bloc'>  <a href="questionnaire/questionnaire.php">Faire le questionnaire</a> </div>
            <div class='bloc'>  <a href="calendrier.php">Accéder à mon calendrier</a> </div>
            <div class='bloc'>  <a href="forum/forum.php">Accéder au forum</a> </div>
            <div class='bloc'> <a href="forum/mesSujets.php">Accéder à mes articles publiés dans le forum</a></div>
            <div class='bloc'>  <a href="profil/profil.php">Accéder / Modifier mes données personnelles</a> </div>
        </div>

        <div class="right">
            <?php include 'calendrier.php'; ?>
        </div>

    </div>

</div>
<br></br>
<br>
<?php include "navbarBas.php" ?>
</body>
</html>
