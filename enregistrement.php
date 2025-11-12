<?php
	$mail=$_POST["email"];
	$mdp=$_POST["mdp"];
	
	function enregistrer($num, $mail, $mdp) {
		require 'bd.php';
		$bdd = getBD();
		
		$rep = $bdd->prepare("INSERT INTO utilisateurs (nom,prenom,genre,niveau_educ_parents, mail, mdp) VALUES ('','','0001-01-01','','',?,?,?);");
		$rep -> execute([$mail,$mdp]);
	}
	
	enregistrer($mail, $mdp);
	echo '<meta http-equiv="refresh" content="0;home.php"/>';



?>
