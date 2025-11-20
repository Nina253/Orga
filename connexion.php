<?php
	session_start();
	require "bd.php";


	/*
	if( !isset($_POST['email']) || !isset($_POST['mdp'])){
		echo json_encode(['success' => 'vide', 'message' => 'Données manquantes']);
		exit;
	}
	*/

	$email = isset($_POST['email']) ? $_POST['email'] : '';
	$mdp  = isset($_POST['mdp']) ? $_POST['mdp'] : '';

	if (!empty($email) && !empty($mdp)) {
    	$bdd = getBD();

    	$stmt = $bdd->prepare("SELECT * FROM utilisateurs WHERE mail = ?");
    	$stmt->execute([$email]);
    	$user = $stmt->fetch(PDO::FETCH_ASSOC);

    	if ($user && password_verify($mdp, $user['mdp'])) {
    		$_SESSION['client'] = ['id' => $user['id_user'], 'email' => $user['mail'],'nom' => $user['nom'],'prenom' => $user['prenom']];

        	// TOKEN
        	if (empty($_SESSION['token'])) {
          	  $_SESSION['token'] = bin2hex(random_bytes(32));
      		  }

          	echo json_encode(['success' => true, 'message' => 'Connexion réussie']);
        	exit;
    	} else {
        	echo json_encode(['success' => false, 'message' => 'Mot de passe ou identifiant invalide']);
         	exit;
        }
  	} else {
    	echo json_encode(['success' => false, 'message' => 'Champs vide']);
    	exit;
	}
?>



