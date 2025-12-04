
<?php
	session_start();
	$date=$_POST['date'];
	function age($date){
		$naissance = new DateTime($date);
		$aujourdHui = new DateTime();
		$difference = $aujourdHui->diff($naissance);
		return $difference->y;
	}
	
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$genre=$_POST['genre'];
	$niv=$_POST['lvl'];
	if(is_string($nom)&&is_string($prenom)){
		$_SESSION["nom"]=$nom;
		$_SESSION["prenom"]=$prenom;
		require '../bd.php';
		$bdd=getBD(); 
		$rep= $bdd->prepare("UPDATE etudiant SET nom=?,prenom=?,age=?,genre=?,niveau_educ_parents=? WHERE mail=?");
		$rep->execute([htmlspecialchars($nom),htmlspecialchars($prenom),age($date),$genre,$niv,$_SESSION['mail']]);
		echo '<meta http-equiv="refresh" content="0;../compte.php"/>';
	} else{
		echo '<meta http-equiv="refresh" content="0;questionnaire_nom.php"/>';
	}
?>
