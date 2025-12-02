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
    function recupidhab($bdd){
        $rep= $bdd->prepare("SELECT id_hab FROM habitudes ORDER BY id_hab DESC LIMIT 1");
        $rep->execute([]);
        $res=$rep->fetch();
        return $res['id_hab'];
    }
    function ajouthab($trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$bdd){
        $resid=recupidhab($bdd);
        $rep2 = $bdd->prepare("INSERT INTO habitudes (duree_travail,duree_reseaux,duree_netflix,job,duree_sommeil,nutrition,freq_sport,sante_mentale,parascolaire,acces_internet,id_etu, id_scolarite, id_hab, date_hab) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,NOW());");
        $rep2 -> execute([$trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$_SESSION['client']['id'],$_SESSION['client']['id_scolarite'],$resid+1]);
        $_SESSION['client']['id_hab']=$resid+1;
    }
    function ajoutdate($trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$bdd){
        $res=recupdate($bdd);
        if ($res===NULL){
            $rep= $bdd->prepare("UPDATE habitudes SET duree_travail=?,duree_reseaux=?,duree_netflix=?,job=?,duree_sommeil=?,nutrition=?,freq_sport=?,sante_mentale=?,parascolaire=?,acces_internet=?,date_hab=NOW() WHERE id_etu=? AND id_hab=?");
            $rep->execute([$trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$_SESSION['client']['id'],$_SESSION['client']['id_hab']]);
            
        } else {
            ajouthab($trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$bdd);
        }
    }
    ajoutdate($trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$bdd);
    echo '<meta http-equiv="refresh" content="0;questionnaire_2.php"/>';
    

?>
