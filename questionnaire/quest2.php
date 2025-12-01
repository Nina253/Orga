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
    $rep= $bdd->prepare("UPDATE habitudes SET duree_travail=?,duree_reseaux=?,duree_netflix=?,job=?,duree_sommeil=?,nutrition=?,freq_sport=?,sante_mentale=?,parascolaire=?,acces_internet=? WHERE id_etu=?");
    $rep->execute([$trav,$reso,$netf,$job,$dodo,$nutr,$sport,$ment,$para,$int,$_SESSION['client']['id']]);
    echo '<meta http-equiv="refresh" content="0;questionnaire_2.php"/>';
    

?>
