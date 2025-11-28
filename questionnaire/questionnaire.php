<?php
	session_start();
?>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
        <title>Questionnaire</title>
    </head>
	<body>
		
    <?php include "../navbar.php" ?>


		<h1 style='font-family: "Montserrat"'>Questionnaire</h1>
		
		<h2 class='h' style='font-family: "Montserrat"'>Tes Habitudes</h2>
		
		<form action="quest2.php" method="post">
		
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>1. Combien de temps, en heures, passes-tu sur les réseaux sociaux (par jour) ?</p>
				<input class="barre" type="number" step="0.1" name="tps" max="24" min="0" required>
			<br>
			
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>2. Combien de temps, en heures, passes-tu sur Netflix ?</p>
			<input class="barre" type="number" step="0.1" name="netflix" max="24" min="0" required>
			<br>
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>3. As-tu un travail en plus de tes études ?</p>
			
			<label class="lign">
			  <input type="radio" name="travail" value="oui"> Oui
			</label>
			
			<label class="lign">
			  <input type="radio" name="travail" value="non"> Non
			</label>
			<br>
			
			<button type="submit" class="suivant" style='font-family: "Silk Serif";font-size: 18px;'>Suivant</button>
			
		</form>
		
		<footer>
			<img class="logo" src="../images/logo.png" alt="logo" >
			<a href="../nous.html" >Qui sommes nous</a>
		</footer>
		
		
	</body>

</html>

