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
		
		<h2 class='h' style='font-family: "Montserrat"'>Tes Habitudes Scolaires</h2>
		
		<form class="formu2" action="quest_3.php" method="post">
			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>1. A combien estimes-tu ton pourcentage de présence ?</p>
			<input class="barre" type="number" name="presence" required>
			</div>
			<br>
			
			<div class="qblock">
			<p style='font-family: "Inter", sans serif; font-size:18px;font-weight : bolder'>2. Quelle est ta moyenne générale ?</p>
			<input class="barre" type="number" step="0.01" name="moy" max="20" required>
			</div>
			<br>
		
			<button type="submit" class="suivant">Suivant</button>
			
		</form>
	
		<?php include "../navbarBas.php" ?>
	</body>
</html>

