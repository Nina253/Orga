<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
        <title>Questionnaire</title>
    </head>
	<body>
		
    <?php include "navbar.php" ?>


		<h1>Questionnaire</h1>
		<p class='c'>C’est parti pour améliorer tes performance, commence par remplir le questionnaire ci-dessous</p>
		<h2 class='h'>Qui es-tu ?</h2>
		
		<form class="quest" action="questionnaire.php" method="post">
			<p><strong>1. Ton prénom</strong></p>
			<input class="barre" type="text" name="prenom" required>

			<p><strong>2. Ton nom</strong></p>
			<input class="barre" type="text" name="nom" required>

			<p><strong>3. Ton genre</strong></p>
			<label class="lign">
			  <input type="radio" name="genre" value="femme"> Femme
			</label>
			
			<label class="lign">
			  <input type="radio" name="genre" value="homme"> Homme
			</label>
			
			<label class="lign">
			  <input type="radio" name="genre" value="autre"> Autre
			</label>
			<br>

			<button type="submit" class="suivant">Suivant</button>
		</form>
		
		<footer>
			<img class="logo" src="images/logo.png" alt="logo" >
			<a href="nous.html" >Qui sommes nous</a>
		</footer>
		
		
	</body>
</html>