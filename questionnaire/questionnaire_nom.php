<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
        <title>Questionnaire</title>
    </head>
	<body>
		
    <?php include "../navbar.php" ?>


		<h1 style='font-family: "Montserrat"'>Questionnaire</h1>
		<p class='c'>C’est parti pour améliorer tes performances ! Commence par ceci...</p>
		<h2 class='h' style='font-family: "Montserrat"'>Qui es-tu ?</h2>
		
		<form class="quest" action="quest1.php" method="post">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>1. Ton prénom</p>
			<input class="barre" type="text" name="prenom" required>

			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>2. Ton nom</p>
			<input class="barre" type="text" name="nom" required>
			
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>3. Ta date de naissance</p>
			<input class="barre" type="date" name="date" required>
			
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>4. Ton genre</p>
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
			
			<button type="submit" class="suivant" style='font-family: "Silk Serif";font-size: 18px;'>Valider</button>
		</form>
		
		<footer>
			<img class="logo" src="../images/logo.png" alt="logo" >
			<a href="../nous.html" >Qui sommes nous</a>
		</footer>
		
		
	</body>
</html>

