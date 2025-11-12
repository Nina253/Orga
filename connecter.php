<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
		
        <title>Connexion</title>
    </head>
	<body>
	    <?php include "navbar.php" ?>

		
		
		<div>	
			<form class="insc" action="connexion.php" method="post">
				<h2>Se connecter</h2>
				Email<br>
				<input class="barre3" type="text" name="email" placeholder="ex: xyz@gmail.com"required><br>
				Numéro de téléphone<br>
				<input class="barre3" type="text" name="num" placeholder="ex: 06 41 41 41 41"required><br>
				Mot de passe<br>
				<input class="barre3" type="password" name="mdp" required>
				<a class="mdpt" href="mdp_oublie.php">mot de passe oublié ?</a>
				<button type="submit" class="bouton_noir2">Connexion</button>
				
			</form>
		</div>
		
		<footer class="pied">
			<img class="logo" src="images/logo.png" alt="logo" >
			<a href="nous.html" >Qui sommes nous</a>
		</footer>
	</body>
</html>

