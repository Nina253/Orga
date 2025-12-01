<?php
	session_start();
    $trav=$_POST['travail'];
	$reso=$_POST['reseaux'];
	$netf=$_POST['netflix'];
	$job=$_POST['job'];
    $dodo=$_POST['dodo'];
    $nutr=$_POST['nutr'];
    $sport=$_POST['sport'];
    $ment=$_POST['mental'];
    $para=$_POST['para'];
    $int=$_POST['co'];
	
    require '../bd.php';
   
    $bdd=getBD();
    function recupdate($bdd){
        $rep= $bdd->prepare("SELECT date_hab FROM habitudes WHERE id_etu=?");
        $rep->execute([$_SESSION['client']['id']]);
        $res=$rep->fetch();
        return $res['date_hab'];
    }
    function ajouthab($bdd){
        $rep2 = $bdd->prepare("INSERT INTO habitudes (id_etu, id_scolarite, id_hab) VALUES (?,?,?);");
        $rep2 -> execute([$_SESSION['client']['id_etu'],$_SESSION['client']['id_scolarite'],$_SESSION['client']['id_hab']+1]);
        $_SESSION['client']['id_hab']=$_SESSION['client']['id_hab']+1;
    }
    function ajoutdate($bdd){
        $res=recupdate($bdd);
        if ($res!=''){
            ajouthab($bdd);
        } else {
            $rep= $bdd->prepare("UPDATE habitudes SET duree_travail=?,duree_reseaux=?,duree_netflix=?,job=?,duree_sommeil=?,nutrition=?,freq_sport=?,sante_mentale=?,parascolaire=?,acces_internet=?,date_hab=NOW() WHERE id_etu=? AND id_hab=");
            $rep->execute([$trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$_SESSION['client']['id'],$_SESSION['client']['id_hab']]);
        }
    }
    ajoutdate($bdd);
    echo '<meta http-equiv="refresh" content="0;questionnaire_2.php"/>';
    

?>
