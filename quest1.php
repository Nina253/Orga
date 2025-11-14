<?php
	$nom=$_POST['nom'];
	$prenom=$_POST['prenom'];
	$genre=$_POST['genre'];
	require 'bd.php';
	$bdd=getBD(); 
	$rep= $bdd->prepare("UPDATE utilisateurs SET nom=?,prenom=?,genre=? WHERE mail=?");
	$rep->execute([$nom,$prenom,$genre,$_SESSION['mail']]);
?>