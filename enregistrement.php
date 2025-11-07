<?php
	$mail=$_POST["email"];
	$num=$_POST["num"];
	$mdp=$_POST["mdp"];
	
	function enregistrer($num, $mail, $mdp) {
		require 'bd.php';
		$bdd = getBD();
		
		$rep = $bdd->prepare("INSERT INTO utilisateurs (nom,prenom,date_naiss,genre,niveau_educ_parents,num, mail, mdp) VALUES ('','','0001-01-01','','',?,?,?);");
		
		$num = (int)$num;
		$rep -> execute([$num,$mail,$mdp]);
	}
	
	enregistrer($num, $mail, $mdp);
	echo '<meta http-equiv="refresh" content="0;home.php"/>';



?>