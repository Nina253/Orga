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
		
		<form class="formu" action="quest2.php" method="post">


			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>1. Combien de temps, en heures, travailles-tu par jour ?</p>
			<input class="barre" type="number" step="0.1" name="travail" max="10" min="0" required>
			</div>
			<br>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>2. Combien de temps, en heures, passes-tu sur les réseaux sociaux (par jour) ?</p>
				<input class="barre" type="number" step="0.1" name="reseaux" max="24" min="0" required>
				</div>
			<br>
			
			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>3. Combien de temps, en heures, passes-tu sur Netflix ?</p>
			<input class="barre" type="number" step="0.1" name="netflix" max="24" min="0" required>
			</div>
			<br>
			
			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>4. Combien de temps, en heures, dors-tu par nuit?</p>
			<input class="barre" type="number" step="0.1" name="dodo" max="10" min="0" required>
			</div>
			<br>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>5. As-tu un travail en plus de tes études ?</p>
			<select class="lign" name="job" required>
				<option value="Yes">Oui</option>
				<option value="No">Non</option>
			</select>
			</div>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>6. Comment qualifirais-tu ta nutrition ?</p>
			<select class="lign" name="nutr" required>
				<option value="Poor">Mauvaise</option>
				<option value="Fair">Correcte</option>
				<option value="Good">Bonne</option>
			</select>
			</div>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>7. A quelle fréquence fais-tu du sport (par jour dans la semaine) ?</p>
				<input class="barre" type="number" name="sport" max="6" min="0" required>
				</div>
			<br>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>8. Combien noterais-tu ta santé mentale (de 1 à 10) ?</p>
				<input class="barre" type="number" name="mental" max="10" min="1" required>
			</div>
			<br>
			

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>9. Pratiques-tu des activités parascolaires ?</p>
			<select class="lign" name="para" required>
				<option value="Yes">Oui</option>
				<option value="No">Non</option>
			</select>
			</div>

			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>10. Comment est votre accès à internet :</p>
			<select class="lign" name="co" required>
				<option value="Poor">Mauvais</option>
				<option value="Average">Moyen</option>
				<option value="Good">Bon</option>
			</select>
			</div>

			<button type="submit" class="suivant">Suivant</button>
			
		</form>
		
		<?php include "../navbarBas.php" ?>
	</body>

</html>

