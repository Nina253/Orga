<?php
session_start();
header('Content-Type: application/json');
include("bd.php");
$bdd = getBD();

$id_sujet = (int)$_POST['id_sujet'];

$stmt = $bdd->prepare("
    SELECT c.*, e.prenom, e.nom
    FROM commentaires c
    LEFT JOIN etudiant e ON e.id_etu = c.id_etu
    WHERE sujet_id = ?
    ORDER BY date_post DESC
");
$stmt->execute([$id_sujet]);
$commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Construire le HTML
ob_start();
foreach($commentaires as $c){
    $prenom = $c['prenom'];
    $nom = $c['nom'];
    $contenu = nl2br(($c['contenu']));
    $date = $c['date_post'];

    echo "<div class='commentaire' id='com-{$c['id']}'>";
    echo "<b>$prenom $nom</b><br>$contenu<br><small>$date</small>";
    if(isset($_SESSION['client']) && $_SESSION['client']['id'] == $c['id_etu']){
        echo "<br><button class='btn_delete_com' onclick='supprimerCommentaire({$c['id']}, {$c['sujet_id']})'>🗑️ Supprimer</button>";
    }

    echo "</div>";
}

$html = ob_get_clean();

echo json_encode([
    'success' => true,
    'html' => $html
]);
