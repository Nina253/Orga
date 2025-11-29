<?php 
	session_start();
?>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
		
        <title>MDP</title>
    </head>
	<body>
    <?php include "../navbar.php" ?>

			
			<form class="insc" action="nouvmdp.php" method="post">
				<h2 style='font-family: "Montserrat"'>Mot de passe oublié</h2>
				<label>Email</label>
				<input class="barre4" type="text" name="email" placeholder="ex: xyz@gmail.com"required><br>
				<label>Nouveau mot de passe</label>
				<input class="barre4" type="password" name="mdp1" required><br>
				<label>Confirmez le mot de passe</label>
				<input class="barre4" type="password" name="mdp2" required><br>
				<button type="submit" class="bouton_noir2">Changer le mot de passe</button>
			</form>
	</body>
</html>