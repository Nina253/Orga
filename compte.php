<?php 
	session_start();
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
        <img src="images/perso.jpg" alt="perso">
        <h1>Bienvenu Prénom Nom</h1>
        <p class="subtitle">Que souhaites-tu faire:</p>
    </div>

    <div class="content">

        <div class="left">
            <div class='bloc'> Accéder à mon tableau de bord
            <button>Faire le questionnaire</button>
            <button>Accéder à mon calendrier</button>
            <button>Accéder au forum</button>
            <button>Accéder à mes articles publiés dans le forum</button>
            <button>Accéder / Modifier mes données personnelles</button>
        </div>

        <div class="right">
            <div class="calendar">
                <h3>Octobre</h3>
                
            </div>

            <div class="today">
                <h4>Aujourd'hui :</h4>
                <ul>
                    <li>enregistre tes habitudes</li>
                    <li>autre tâches de programmées</li>
                </ul>
            </div>
        </div>

    </div>

</div>
</body>
</html>