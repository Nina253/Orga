<?php
	$mail=$_POST["email"];
	$mdp=$_POST["mdp"];
	$num=$_POST["num"];
	
	function enregistrer($mail, $mdp) {
		require 'bd.php';
		$bdd = getBD();
		
		$rep = $bdd->prepare("INSERT INTO utilisateurs (mail, mdp, num) VALUES (?,?);");
		$rep -> execute([$mail,$mdp,$num]);
	}
	
	enregistrer($mail, $mdp);
	echo '<meta http-equiv="refresh" content="0;home.php"/>';



?>




