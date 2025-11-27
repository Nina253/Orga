
<?php
	session_start();
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$genre=$_POST['genre'];
	$date = str_replace("-", "/",$_POST['date']); 
	echo $_SESSION['mail'];
	if(is_string($nom)&&is_string($prenom)){
		$_SESSION["nom"]=$nom;
		$_SESSION["prenom"]=$prenom;
		require 'bd.php';
		$bdd=getBD(); 
		$rep= $bdd->prepare("UPDATE etudiant SET nom=?,prenom=?,genre=? WHERE mail=?");
		$rep->execute([$nom,$prenom,$genre,$_SESSION['mail']]);
		echo '<meta http-equiv="refresh" content="0;../compte.php"/>';
	} else{
		echo '<meta http-equiv="refresh" content="0;../questionnaire_nom.php"/>';
	}
?>
