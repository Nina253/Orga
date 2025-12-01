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
			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>1. Ton prénom</p>
			<input class="barre" type="text" name="prenom" required>
			</div>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>2. Ton nom</p>
			<input class="barre" type="text" name="nom" required>
			</div>
			
			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>3. Ta date de naissance</p>
			<input class="barre" type="date" name="date" required max="<?= date('Y-m-d') ?>">
			</div>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>3. Ton niveau d'études</p>
			<select class="lign" name="lvl" required>
				<option value="High School">Lycéen</option>
				<option value="Bachelor">Bachelier</option>
				<option value="Master">Master</option>
				<option value="None">Autre</option>
			</select>
			</div>

			<div class="qblock">
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
			</div>
			<br>
			
			<button type="submit" class="suivant">Valider</button>
		</form>
	<br></br>
	<br></br>
	<br></br>
	<br></br>
	<?php include "../navbarBas.php" ?>
	</body>
</html>

