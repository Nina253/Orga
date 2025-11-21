<?php
	session_start();
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$genre=$_POST['genre'];
	$lvl=$_POST['lvl'];
	$date = str_replace("-", "/",$_POST['date']); 
	$age=2025-(explode('/',$date)[0]);
	if(is_string($nom)&&is_string($prenom)){
		$_SESSION["nom"]=$nom;
		$_SESSION["prenom"]=$prenom;
		require 'bd.php';
		$bdd=getBD(); 
		$rep= $bdd->prepare("UPDATE etudiant SET nom=?,prenom=?,genre=?,niveau_educ_parents=?,age=? WHERE mail=?");
		$rep->execute([$nom,$prenom,$genre,$lvl,$age,$_SESSION['mail']]);
		echo '<meta http-equiv="refresh" content="0;compte.php"/>';
	} else{
		echo '<meta http-equiv="refresh" content="0;questionnaire_nom.php"/>';
	}
?>
