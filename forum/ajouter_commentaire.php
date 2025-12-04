<?php
session_start();
header('Content-Type: application/json');
include("../bd.php");
$bdd = getBD();

// Vérification connexion
if (!isset($_SESSION['client'])) {
    echo json_encode(['success'=>false, 'message'=>'Vous devez être connecté.']);
    exit;
}

// Récupérer données
$id_sujet = (int)($_POST['id_sujet'] ?? 0);
$contenu = trim($_POST['contenu'] ?? '');
$id_etu = $_SESSION['client']['id'];

if ($id_sujet <= 0 || $contenu === '') {
    echo json_encode(['success'=>false, 'message'=>'Commentaire invalide.']);
    exit;
}

// Insertion
$stmt = $bdd->prepare("INSERT INTO commentaires (sujet_id, id_etu, contenu, date_post) VALUES (?, ?, ?, NOW())");
$stmt->execute([$id_sujet, $id_etu, htmlspecialchars($contenu)]);

// ID du commentaire inséré
$id_commentaire = $bdd->lastInsertId();

// Récupérer l’utilisateur
$q = $bdd->prepare("SELECT prenom, nom FROM etudiant WHERE id_etu = ?");
$q->execute([$id_etu]);
$user = $q->fetch(PDO::FETCH_ASSOC);

// Format HTML avec le BON bouton supprimer
$html = "<div class='commentaire' id='com-$id_commentaire'>";
$html .= "<b>{$user['prenom']} {$user['nom']}</b><br>".nl2br($contenu)."<br><small>À l'instant</small>";
$html .= "<button class='btn_delete_com' onclick='supprimerCommentaire($id_commentaire, $id_sujet)'>Supprimer</button>";
$html .= "</div>";

// Nouveau nombre de commentaires
$c = $bdd->prepare("SELECT COUNT(*) FROM commentaires WHERE sujet_id = ?");
$c->execute([$id_sujet]);
$nbCommentaires = $c->fetchColumn();

echo json_encode([
    'success'=>true,
    'html'=>$html,
    'message'=>'Commentaire ajouté !',
    'nb_com' => $nbCommentaires
]);
?>
