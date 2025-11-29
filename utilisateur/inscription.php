<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
		
        <title>Inscription</title>
    </head>
	<body>
    <?php include "../navbar.php" ?>

		
			
			<form class="insc" action="enregistrement.php" method="post">
				<h2 style='font-family: "Montserrat"'>Créer un compte</h2>
				<label>Email</label>
				<input class="barre3" type="text" name="email" placeholder="ex: xyz@gmail.com" required><br>
				<label>Numéro de téléphone</label>
				<input class="barre3" type="text" name="num" placeholder="ex: 0641414141" required><br>
				<label>Mot de passe</label>
				<input class="barre3" type="password" name="mdp" required>
				<button type="submit" class="bouton_noir2">S'inscrire</button>
			</form>
		
		
		<footer class="pied">
			<img class="logo" src="../images/logo.png" alt="logo" >
			<a href="../nous.html" >Qui sommes nous</a>
		</footer>
	</body>
</html>



