<?php
	$mail=$_POST["email"];
	$mdp=$_POST["mdp"];
	
	function enregistrer($mail, $mdp) {
		require 'bd.php';
		$bdd = getBD();
		
		$rep = $bdd->prepare("INSERT INTO utilisateurs (mail, mdp) VALUES (?,?);");
		$rep -> execute([$mail,$mdp]);
	}
	
	enregistrer($mail, $mdp);
	echo '<meta http-equiv="refresh" content="0;home.php"/>';



?>



