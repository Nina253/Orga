<?php
	session_start();


	$_SESSION["mail"]=$_POST["email"];
	$_SESSION["mdp"]=$_POST["mdp"];
	$_SESSION["num"]=$_POST["num"];

	if(isset($_SESSION['mail'])&&isset($_SESSION['mdp'])){
		
			require "bd.php";
			$bdd=getBD(); 
			$repR= $bdd->prepare(" SELECT e.nom, e.prenom, p.url AS url , p.id_photo AS id_photo FROM etudiant e JOIN photo p ON e.id_photo = p.id_photo WHERE e.mail = ?");
			$repR->execute([$_SESSION['mail']]);
			$verf = $repR->fetch();
			$rep= $bdd->prepare("SELECT * FROM etudiant WHERE mail = ?");
 			$rep->execute([$_SESSION['mail']]);
			$utl = $rep->fetch();
		
			if (password_verify($_SESSION['mdp'],$utl['mdp'])){
				$_SESSION['client'] = ['id' => $utl['id_etu'] ,  'id_photo' => $verf['id_photo'] ,  'url' => $verf['url']  ] ;
				if($verf['nom']==''||$verf['prenom']==''){
					echo '<meta http-equiv="refresh" content="0;questionnaire_nom.php"/>';
				} else{
					$_SESSION["nom"]=$verf['nom'];
					$_SESSION["prenom"]=$verf['prenom'];
					echo '<meta http-equiv="refresh" content="0;compte.php"/>';
				}
				die;
			} else{
				echo '<meta http-equiv="refresh" content="0;connecter.php"/>';
				die;
			}
	} else{
			echo '<meta http-equiv="refresh" content="0;connexion.php"/>';
			die;
	}
?>




