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

	<?php
		include "quest1.php"
	?>
		<h1>Questionnaire</h1>
		
		<h2 class='h'>Tes Habitudes</h2>
		
		<form action="questionnaire_2.php" method="post">
		
			<p><strong>1. Combien de temps passes-tu sur les réseaux sociaux (par jour) ?</strong></p>
			
			<label class="col">
			  <input type="radio" name="tps" value="0"> Moins de 2 heures
			</label>
			
			<label class="col">
			  <input type="radio" name="tps" value="2"> Moins de 4 heures
			</label>
			
			<label class="col">
			  <input type="radio" name="tps" value="4"> Moins de 6 heures
			</label>
			
			<label class="col">
			  <input type="radio" name="tps" value="6"> Plus de 6 heures
			</label>
			<br>
			
			<p><strong>2. Combien de temps passes-tu sur Netflix ?</strong></p>
			
			<label class="col">
			  <input type="radio" name="netflix" value="0"> Moins de 2 heures
			</label>
			
			<label class="col">
			  <input type="radio" name="netflix" value="2"> Moins de 4 heures
			</label>
			
			<label class="col">
			  <input type="radio" name="netflix" value="4"> Moins de 6 heures
			</label>
			
			<label class="col">
			  <input type="radio" name="netflix" value="6"> Plus de 6 heures
			</label>
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

