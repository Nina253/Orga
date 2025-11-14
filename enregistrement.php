<?php
	$mail=$_POST["email"];
	$mdp=$_POST["mdp"];
	$num=$_POST["num"];

	$mdpC=password_hash($mdp,PASSWORD_DEFAULT);
	
	function enregistrer($mail, $mdp) {
		require 'bd.php';
		$bdd = getBD();
		
		$rep = $bdd->prepare("INSERT INTO utilisateurs (nom,prenom,date_naiss,genre,niveau_educ_parents,mail, mdp, num) VALUES ('','','','','0001/01/01',?,?,?);");
		$rep -> execute([$mail,$mdpC,$num]);
	}
	
	enregistrer($mail, $mdp,$num);
	echo '<meta http-equiv="refresh" content="0;home.php"/>';



?>







