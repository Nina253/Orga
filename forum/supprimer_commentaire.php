<?php
session_start();
header('Content-Type: application/json');
include("../bd.php");
$bdd = getBD();

if(!isset($_SESSION['client'])){
    echo json_encode(['success'=>false, 'message'=>'Vous devez être connecté']);
    exit;
}

$id_com = (int)($_POST['id_com'] ?? 0);
$id_etu = $_SESSION['client']['id'];

// Récupérer l’auteur du commentaire
$check = $bdd->prepare("SELECT sujet_id, id_etu FROM commentaires WHERE id = ?");
$check->execute([$id_com]);
$com = $check->fetch(PDO::FETCH_ASSOC);

if(!$com){
    echo json_encode(['success'=>false, 'message'=>'Commentaire introuvable']);
    exit;
}

// Seul l’auteur peut supprimer
if($com['id_etu'] != $id_etu){
    echo json_encode(['success'=>false, 'message'=>'Action interdite']);
    exit;
}

// Suppression
$delete = $bdd->prepare("DELETE FROM commentaires WHERE id = ?");
$delete->execute([$id_com]);

// Renvoyer le nouveau compteur
$c = $bdd->prepare("SELECT COUNT(*) FROM commentaires WHERE sujet_id = ?");
$c->execute([$com['sujet_id']]);
$nbCommentaires = $c->fetchColumn();

echo json_encode([
    'success'=>true,
    'message'=>'Commentaire supprimé',
    'id_com'=>$id_com,
    'nb_com'=>$nbCommentaires
]);
