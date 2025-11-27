<?php
function genererIdEtu($bdd) {
    $stmt = $bdd->query("SELECT id_etu FROM etudiant ORDER BY id_etu DESC LIMIT 1");
    $lastId = $stmt->fetchColumn() ?: 'E000'; // Si aucun étudiant, on commence à E000

    $number = (int)substr($lastId, 1);

    
    $newNumber = $number + 1;

    $newId = 'S' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);

    return $newId;
}

	$mail=$_POST["email"];
	$mdp=$_POST["mdp"];
	$num=$_POST["num"];

	$mdpC=password_hash($mdp,PASSWORD_DEFAULT);
	
	function enregistrer($mail, $mdpC, $num) {
		require '../bd.php';
		$bdd = getBD();
		$id_etu = genererIdEtu($bdd);
		$rep = $bdd->prepare("INSERT INTO etudiant (id_etu,nom,prenom,age, genre, mail,mdp, niveau_educ_parents) VALUES (?,'','',NULL,'',?,?,'');");
    	$rep->execute([$id_etu,$mail,$mdpC]);
	}
	
	if(ctype_digit($num)){
		enregistrer($mail, $mdpC,$num);
		echo '<meta http-equiv="refresh" content="0;connecter.php"/>';
	} else {
		echo '<meta http-equiv="refresh" content="0;inscription.php"/>';
	}

?>








