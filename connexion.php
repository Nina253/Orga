<?php
	session_start();


	$_SESSION["mail"]=$_POST["email"];
	$_SESSION["mdp"]=$_POST["mdp"];
	$_SESSION["num"]=$_POST["num"];

	if(isset($_SESSION['mail'])&&isset($_SESSION['mdp'])){
		
			require "bd.php";
			$bdd=getBD(); 
			$rep= $bdd->prepare("SELECT * FROM utilisateurs WHERE mail = ?");
 			$rep->execute([$_SESSION['mail']]);
			$utl = $rep->fetch();
		
			if (password_verify($_SESSION['mdp'],$utl['mdp'])){
				$_SESSION['client']=$utl;
				echo '<meta http-equiv="refresh" content="0;questionnaire_nom.php"/>';
				die;
			} else{
				echo '<meta http-equiv="refresh" content="0;connexion.php"/>';
				die;
			}
	} else{
			echo '<meta http-equiv="refresh" content="0;connexion.php"/>';
			die;
	}
?>



