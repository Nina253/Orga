<?php
	session_start();
	$reso=$_POST['reseaux'];
	$netf=$_POST['netflix'];
	$job=$_POST['job'];
	
    require 'bd.php';
    $bdd=getBD(); 
    //MARCHE PAS ENCORE FAUT VOIR POUR ID SCOLARTIE $rep= $bdd->prepare("UPDATE habitudes SET nom=?,prenom=?,genre=?,niveau_educ_parents=?,age=? WHERE mail=?");
    $rep->execute([$nom,$prenom,$genre,$lvl,$age,$_SESSION['mail']]);
    echo '<meta http-equiv="refresh" content="0;questionnaire_2.php"/>';

?>
