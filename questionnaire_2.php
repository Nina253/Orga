<?php
	session_start();
?>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
        <title>Questionnaire</title>
    </head>
	<body>
		
		
		<header>
			<a href="home.php"><img class="logo" src="images/logo.png" alt="logo" ></a>
			<a href="tableau_de_bord.php">Tableau De Bord</a>
			<a href="forum.php">Forum</a>
			<a href="deconnexion.php" class="bouton_noir">Deconnexion</a>
			
		</header>

		<h1>Questionnaire</h1>
		
		<h2 class='h'>Tes Habitudes Scolaires</h2>
		
		<form action="questionnaire_2.php" method="post">
		
			<p><strong>1. Quel est ton pourcentage de présence ?</strong></p>
			<input class="barre" type="number" name="presence" required>
			<br>
			
			<p><strong>2. Quelle est ta moyenne générale ?</strong></p>
			<input class="barre" type="number" step="0.1" name="moy" required>
			<br>
		
			<button type="submit" class="suivant">Suivant</button>
			
		</form>
		
		<footer>
			<img class="logo" src="images/logo.png" alt="logo" >
			<a href="nous.html" >Qui sommes nous</a>
		</footer>
		
		
	</body>
</html>