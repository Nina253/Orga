<?php
session_start();
header('Content-Type: application/json');
include("bd.php");
$bdd = getBD();

if(!isset($_SESSION['client'])){
    echo json_encode(['success'=>false,'message'=>'Vous devez être connecté']);
    exit;
}

$id_com = (int)($_POST['id_com'] ?? 0);
$contenu = trim($_POST['contenu'] ?? '');
$id_etu = $_SESSION['client']['id'];

if($id_com <= 0 || $contenu === ''){
    echo json_encode(['success'=>false,'message'=>'Contenu invalide']);
    exit;
}

// Vérifier que le commentaire appartient à l'utilisateur
$q = $bdd->prepare("SELECT sujet_id, id_etu FROM commentaires WHERE id = ?");
$q->execute([$id_com]);
$com = $q->fetch(PDO::FETCH_ASSOC);

if(!$com || $com['id_etu'] != $id_etu){
    echo json_encode(['success'=>false,'message'=>'Action interdite']);
    exit;
}

// Mettre à jour le commentaire
$stmt = $bdd->prepare("UPDATE commentaires SET contenu = ? WHERE id = ?");
$stmt->execute([$contenu, $id_com]);

// Préparer le HTML du commentaire modifié
$html = "<b>Vous</b><br>".nl2br(($contenu))."<br><small>À l'instant</small>";
$html .= "<br><button class='btn_edit_com' onclick='modifierCommentaire($id_com, {$com['sujet_id']})'>✏️ Modifier</button>";
$html .= "<button class='btn_delete_com' onclick='supprimerCommentaire($id_com, {$com['sujet_id']})'>🗑️ Supprimer</button>";

// Nouveau compteur
$c = $bdd->prepare("SELECT COUNT(*) FROM commentaires WHERE sujet_id = ?");
$c->execute([$com['sujet_id']]);
$nbCommentaires = $c->fetchColumn();

echo json_encode(['success'=>true, 'html'=>$html, 'nb_com'=>$nbCommentaires]);
