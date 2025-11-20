<?php
session_start();
include("bd.php");
$bdd = getBD();

if(!isset($_SESSION["client"])){
    echo json_encode(["success"=>false, "message"=>"Non autorisé"]);
    exit;
}

if(!isset($_POST['id_sujet'])){
    echo json_encode(["success"=>false, "message"=>"ID manquant"]);
    exit;
}

$id_sujet = intval($_POST['id_sujet']);
$id_user = $_SESSION["client"]["id"];

// Vérifier que c’est bien l’auteur
$sql = "SELECT id_etu FROM sujets WHERE id = ?";
$stmt = $bdd->prepare($sql);
$stmt->execute([$id_sujet]);
$sujet = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$sujet){
    echo json_encode(["success"=>false, "message"=>"Sujet introuvable"]);
    exit;
}

if($sujet['id_etu'] != $id_user){
    echo json_encode(["success"=>false, "message"=>"Vous n'êtes pas l'auteur"]);
    exit;
}

// Supprimer les commentaires + likes liés
$bdd->prepare("DELETE FROM commentaires WHERE sujet_id = ?")->execute([$id_sujet]);
$bdd->prepare("DELETE FROM likes_sujets WHERE sujet_id = ?")->execute([$id_sujet]);

// Supprimer le sujet
$bdd->prepare("DELETE FROM sujets WHERE id = ?")->execute([$id_sujet]);

echo json_encode(["success"=>true, "message"=>"Sujet supprimé"]);
