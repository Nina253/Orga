<?php
session_start();
header('Content-Type: application/json');
include("bd.php");
$bdd = getBD();

if(!isset($_SESSION['client'])){
    echo json_encode(['success'=>false, 'message'=>'Connectez-vous pour liker.']);
    exit;
}

$id_etu = $_SESSION['client']['id'];
$id_sujet = (int)$_POST['id_sujet'];

// Vérifie si déjà liké
$stmt = $bdd->prepare("SELECT * FROM likes_sujets WHERE sujet_id=? AND id_etu=?");
$stmt->execute([$id_sujet, $id_etu]);

if($stmt->fetch()){
    // Déjà liké → on enlève le like
    $bdd->prepare("DELETE FROM likes_sujets WHERE sujet_id=? AND id_etu=?")->execute([$id_sujet, $id_etu]);
} else {
    // Ajout du like
    $bdd->prepare("INSERT INTO likes_sujets (sujet_id, id_etu) VALUES (?, ?)")->execute([$id_sujet, $id_etu]);
}

// Compte le nombre de likes
$nb = $bdd->prepare("SELECT COUNT(*) FROM likes_sujets WHERE sujet_id=?");
$nb->execute([$id_sujet]);
$count = $nb->fetchColumn();

echo json_encode(['success'=>true, 'nb_likes'=>$count]);
