<?php
	session_start();
?>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
		
        <title>Mon Profil</title>
    </head>
	<body>
		
		
		<header>
			<a href="home.php"><img class="logo" src="images/logo.png" alt="logo" ></a>
			<a href="tableau_de_bord.php">Tableau De Bord</a>
			<a href="forum.php">Forum</a>
			<a href="deconnexion.php" class="bouton_noir">Deconnexion</a>
			
		</header>

		<h1>Mes Informations</h1>
		<p class='c'>Ici tu peux modifier si tu le souhaites tes informations personnelles</p>
		
		<form class="pfl" action="mon_compte.php" method="post">
			<p>votre prénom</p><br>
			<input class="barre2" type="text" name="prenom">
			<button type="submit">modifier</button>
		</form>
		
		<form class="pfl" action="mon_compte.php" method="post">
			<p>votre nom</p><br>
			<input class="barre2" type="text" name="nom">
			<button type="submit">modifier</button>
		</form>
		
		<form class="pfl" action="profil.php" method="post">
			<p>votre adresse mail</p><br>
			<input class="barre2" type="text" name="mail">
			<button type="submit">modifier</button>
		</form>
		
		<footer class="pied">
			<img class="logo" src="images/logo.png" alt="logo" >
			<a href="nous.html" >Qui sommes nous</a>
		</footer>
		
		<img class="perso" src="images/perso.jpg" alt="logo">
		
	</body>
</html>