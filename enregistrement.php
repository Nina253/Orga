<?php
	$mail=$_POST["email"];
	$mdp=$_POST["mdp"];
	
	function enregistrer($mail, $mdp) {
		require 'bd.php';
		$bdd = getBD();
		
		$rep = $bdd->prepare("INSERT INTO etudiant (id_etud,nom,prenom,genre,niveau_educ_parents, mail, mdp) VALUES ('','','','',?,?);");
		$rep -> execute([$mail,$mdp]);
	}
	
	enregistrer($mail, $mdp);
	echo '<meta http-equiv="refresh" content="0;home.php"/>';



?>


