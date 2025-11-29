<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
		
        <title>Connexion</title>
    </head>
	<body>
	    <?php include "../navbar.php" ?>

		
		
		<div>	
			<form class="insc" action="connexion.php" method="post">
				<h2 style='font-family: "Montserrat"'>Se connecter</h2>
				<label>Email</label>
				<input class="barre3" type="text" name="email" placeholder="ex: xyz@gmail.com"required><br>
				<label>Mot de passe</label>
				<input class="barre3" type="password" name="mdp" required>
				<em><a class="mdpt" href="mdp_oublie.php">Mot de passe oublié ?</a></em>
				<button type="submit" class="bouton_noir2">Connexion</button>
				

				<div class="bloc"> 
				<a href="inscription.php"> Créer un compte</a>
			</div>
			</form>

		</div>
	</body>
</html>


