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
				<h2>Se connecter</h2>
				Email<br>
				<input class="barre3" type="text" name="email" placeholder="ex: xyz@gmail.com"required><br>
				Mot de passe<br>
				<input class="barre3" type="password" name="mdp" required>
				<a class="mdpt" href="mdp_oublie.php">mot de passe oublié ?</a>
				<button type="submit" class="bouton_noir2">Connexion</button>
				

				<div class="bloc"> 
				<a href="inscription.php"> Créer un compte</a>
			</div>
			</form>

		</div>
		
		<footer class="pied">
			<img class="logo" src="../images/logo.png" alt="logo" >
			<a href="../nous.html" >Qui sommes nous</a>
		</footer>
	</body>
</html>


