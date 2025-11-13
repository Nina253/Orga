<?php
	$mail=$_POST["email"];
	$mdp=$_POST["mdp"];
	$num=$_POST["num"];

	$mdpC=password_hash($mdp,PASSWORD_DEFAULT);
	
	function enregistrer($mail, $mdp) {
		require 'bd.php';
		$bdd = getBD();
		
		$rep = $bdd->prepare("INSERT INTO utilisateurs (mail, mdp, num) VALUES (?,?);");
		$rep -> execute([$mail,$mdpC,$num]);
	}
	
	enregistrer($mail, $mdp);
	echo '<meta http-equiv="refresh" content="0;home.php"/>';



?>





