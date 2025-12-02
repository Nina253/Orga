<?php
	session_start();
    $pres=$_POST['presence'];
	$moyenne=$_POST['moy'];
    $moy = ($moyenne/20)*100;
	
    require '../bd.php';
    $bdd=getBD();
    function recupdate($bdd){
        $rep= $bdd->prepare("SELECT date_scolarite FROM scolarite WHERE id_etu=?");
        $rep->execute([$_SESSION['client']['id']]);
        $res=$rep->fetch();
        return $res['date_scolarite'];
    }

    function recupidsco($bdd){
        $rep= $bdd->prepare("SELECT id_scolarite FROM scolarite ORDER BY id_scolarite DESC LIMIT 1");
        $rep->execute([]);
        $res=$rep->fetch();
        return $res['id_scolarite'];
    }
    
    
    function ajoutsco($pres,$moy,$bdd){
        $resid=recupidsco($bdd);
        $rep2 = $bdd->prepare("INSERT INTO scolarite (id_etu,id_scolarite,presence,notes,date_scolarite) VALUES (?,?,?,?,YEAR(NOW()));");
        $rep2 -> execute([$_SESSION['client']['id'],$resid+1,$pres,$moy]);
        $_SESSION['client']['id_scolarite']=$resid+1;
    }

    function ajoutdate($pres,$moy,$bdd){
        $res=recupdate($bdd);
        if ($res===NULL){
            $rep= $bdd->prepare("UPDATE scolarite SET presence=?,notes=?,date_scolarite=YEAR(NOW()) WHERE id_etu=? AND id_scolarite=?");
            $rep->execute([$pres,$moy,$_SESSION['client']['id'],$_SESSION['client']['id_scolarite']]);
            
        } else {
            ajoutsco($pres,$moy,$bdd);
        }
    }

    
    ajoutdate($pres,$moy,$bdd);
    echo '<meta http-equiv="refresh" content="0;../home.php"/>';


?>
