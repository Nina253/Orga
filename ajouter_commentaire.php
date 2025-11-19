<?php
session_start();
header('Content-Type: application/json');
include("bd.php");
$bdd = getBD();

if(!isset($_SESSION['client'])){
    echo json_encode(['success'=>false,'message'=>'Connectez-vous.']);
    exit;
}

$id_etu = $_SESSION['client'];
$id_sujet = (int)$_POST['id_sujet'];
$contenu = trim($_POST['contenu']);

if($contenu === ""){
    echo json_encode(['success'=>false,'message'=>'Commentaire vide.']);
    exit;
}

$stmt = $bdd->prepare("INSERT INTO commentaires (sujet_id, id_etu, contenu) VALUES (?, ?, ?)");
$stmt->execute([$id_sujet, $id_etu, $contenu]);

// Recharge les commentaires
ob_start();
include('charger_commentaires.php');
$html = ob_get_clean();

echo json_encode(['success'=>true,'html'=>$html]);
