<?php 
	session_start();
	$mail=$_POST['email'];
	$Nmdp=$_POST['mdp1'];
	$Nmdp2=$_POST['mdp2'];
	if($Nmdp==$Nmdp2){
		$NmdpC=password_hash($Nmdp,PASSWORD_DEFAULT);
		require "bd.php";
		$bdd=getBD(); 
		$rep= $bdd->prepare("SELECT * FROM utilisateurs WHERE mail = ?");
		$rep->execute([$mail]);
		$utl = $rep->fetch();   
		if (!$utl) {
			echo '<meta http-equiv="refresh" content="0;mdp_oublie.php"/>';
		} else {
			$rep= $bdd->prepare("UPDATE utilisateurs SET mdp = ? WHERE mail = ?");
			$rep->execute([$Nmdp,$mail]);
			$_SESSION['mdp']==$Nmdp;
			echo '<meta http-equiv="refresh" content="0;connecter.php"/>';
		}
	} else {
		echo '<meta http-equiv="refresh" content="0;mdp_oublie.php"/>';
	}
	
?>
