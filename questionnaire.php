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
		
    <?php include "navbar.php" ?>


		<h1>Questionnaire</h1>
		
		<h2 class='h'>Tes Habitudes</h2>
		
		<form action="quest2.php" method="post">
		
			<p><strong>1. Combien de temps, en heures, passes-tu sur les réseaux sociaux (par jour) ?</strong></p>
				<input class="barre" type="number" step="0.1" name="tps" max="24" min="0" required>
			<br>
			
			<p><strong>2. Combien de temps, en heures, passes-tu sur Netflix ?</strong></p>
			<input class="barre" type="number" step="0.1" name="netflix" max="24" min="0" required>
			<br>
			<p><strong>3. As-tu un travail en plus de tes études ?</strong></p>
			
			<label class="lign">
			  <input type="radio" name="travail" value="oui"> Oui, la semaine et le week-end
			</label>
			
			<label class="lign">
			  <input type="radio" name="travail" value="ouiwk"> Oui, le week-end
			</label>
			
			<label class="lign">
			  <input type="radio" name="travail" value="non"> Non
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

