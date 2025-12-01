<?php
	session_start();
    $pres=$_POST['presence'];
	$moyenne=$_POST['moy'];
    $moy = ($moyenne/20)*100;
	
    require '../bd.php';
    $bdd=getBD(); 
    $rep= $bdd->prepare("UPDATE scolarite SET presence=?,notes=? WHERE id_etu=?");
    $rep->execute([$pres,$moy,$_SESSION['client']['id']]);
    echo '<meta http-equiv="refresh" content="0;../home.php"/>';
    

?>
