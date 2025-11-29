<?session_start();?>
<!DOCTYPE html>
<html lang="fr">
    <head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
        
        <title>Orga+</title>
    </head>
    <body>
    <?php include "navbar.php" ?>


	<h1 id="h1_ac" style='font-family: "Montserrat"'>Bienvenue dans l'univers Orga+</h1>
	<div class="conteneur">
	<div class="text">
	<h3 style='font-family: "Montserrat"'>Ton guide pour mieux t’organiser et réussir</h3>
		<p>Si vous souhaitez améliorer vos performances académiques, vous êtes sur le site qu’il vous faut !
		Avec Orga+, nous vous conseillons pour mieux vous organiser au quotidien. Vous recevrez des conseils personnalisés basés sur un questionnaire qui permettra de comprendre vos habitudes actuelles.
		De plus, vous pourrez enregistrer et suivre quotidiennement votre évolution.
		Pour commencer, vous pouvez faire une simulation rapide de vos performances actuelles en cliquant ci-dessous :</p>
		<a class="bouton_bleu" href="simulateur.php">Simulateur de performance</a>
	<p>Vous pouvez également commencer immédiatement en remplissant le questionnaire, qui vous permettra d’obtenir des conseils personnalisés en cliquant ci-dessous: </p>
		<a class="bouton_bleu" href="<?php if (isset($_SESSION['client'])){echo 'questionnaire/questionnaire.php';}else{echo 'utilisateur/connecter.php';} ?>">Questionnaire</a>
		<p>Et pour terminer, nous vous proposons un forum dédié aux étudiants, un espace d’échange et de partage.
		Vous pourrez y poser vos questions, partager vos expériences, trouver des conseils pratiques et bénéficier du soutien d’étudiants qui vivent les mêmes défis que vous.
		C’est l’endroit idéal pour obtenir une aide complémentaire, trouver de la motivation et avancer ensemble vers de meilleures performances académiques.</p>
		<a class="bouton_bleu" href="/Orga/forum/forum.php">Forum</a>
	</div>	

	 <img id="page_accueil" src="images/image_accueil.png" alt="accueil" >
	</div>
	<?php include "navbarbas.php" ?>
    </body>
</html>
