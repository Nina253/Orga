<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
		
        <title>MDP</title>
    </head>
	<body>
		<header>
			<a href="home.php"><img class="logo" src="images/logo.png" alt="logo" ></a>
			<a href="tableau_de_bord.php">Tableau De Bord</a>
			<a href="forum.php">Forum</a>
			<a href="connecter.php" class="bouton_noir">Se connecter</a>
		</header>
		
		
			
			<form class="insc" action="connecter.php" method="post">
				<h2>Mot de passe oublié</h2>
				Email<br>
				<input class="barre4" type="text" name="email" placeholder="ex: xyz@gmail.com"required><br>
				Nouveau mot de passe<br>
				<input class="barre4" type="password" name="mdp1" required><br>
				Confirmez le mot de passe<br>
				<input class="barre4" type="password" name="mdp2" required><br>
				<button type="submit" class="bouton_noir2">Changer le mot de passe</button>
			</form>
		
		
		<footer class="pied">
			<img class="logo" src="images/logo.png" alt="logo" >
			<a href="nous.html" >Qui sommes nous</a>
		</footer>
	</body>
</html>