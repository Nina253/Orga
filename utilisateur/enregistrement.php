<?php
require_once '../bd.php';
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
	

	function id_scoo(){
		$bdd = getBD();
		$rep = $bdd->prepare("SELECT id_scolarite FROM scolarite ORDER BY id_scolarite DESC LIMIT 1");
		$rep-> execute();
		$res = $rep->fetch();
		return $res['id_scolarite']+1;
	}
	function id_hab(){
		$bdd = getBD();
		$rep = $bdd->prepare("SELECT id_hab FROM habitudes ORDER BY id_hab DESC LIMIT 1");
		$rep-> execute();
		$res = $rep->fetch();
		return $res['id_hab']+1;
	}

	function enregistrer($mail, $mdpC, $num) {
		$bdd = getBD();
		$id_etu = genererIdEtu($bdd);
		$rep = $bdd->prepare("INSERT INTO etudiant (id_etu,nom,prenom,age, genre, mail,mdp, niveau_educ_parents) VALUES (?,'','',NULL,'',?,?,'');");
    	$rep->execute([$id_etu,$mail,$mdpC]);
		return $id_etu;
	}
	function ajout_sco($mail, $mdpC,$num) {
		$id_sc = id_scoo();
		$id_et=enregistrer($mail, $mdpC,$num);
		$bdd = getBD();
		$rep2 = $bdd->prepare("INSERT INTO scolarite (id_etu, id_scolarite) VALUES (?,?);");
		$rep2 -> execute([$id_et,$id_sc]);
		return [$id_sc,$id_et];
	}
	function ajout_hab($mail, $mdpC,$num) {
		$bdd = getBD();
		$ids = ajout_sco($mail, $mdpC,$num);
		$id_hab = id_hab();
		$rep2 = $bdd->prepare("INSERT INTO habitudes (id_etu, id_scolarite, id_hab) VALUES (?,?,?);");
		$rep2 -> execute([$ids[1],$ids[0],$id_hab]);		
	}
	
	if(ctype_digit($num)){
		ajout_hab($mail, $mdpC,$num);
		echo '<meta http-equiv="refresh" content="0;connecter.php"/>';
	} else {
		echo '<meta http-equiv="refresh" content="0;inscription.php"/>';
	}

?>
