<?php
	session_start();
	$_SESSION["mail"]=$_POST["email"];
	$_SESSION["mdp"]=$_POST["mdp"];
	$_SESSION["num"]=$_POST["num"];
	if(isset($_SESSION['mail'])&&isset($_SESSION['mdp'])){
			require "bd.php";
			$bdd=getBD(); 
			$rep= $bdd->prepare("SELECT * FROM clients WHERE mail = ?");
 			$rep->execute([$_SESSION['mail']]);

?>
