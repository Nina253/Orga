<?php
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
    echo "<div class='commentaire'>";
    echo "<b>{$c['prenom']} {$c['nom']}</b><br>";
    echo nl2br(($c['contenu']));
    echo "<br><small>{$c['date_post']}</small>";
    echo "</div>";
}
$html = ob_get_clean();

echo json_encode([
    'success' => true,
    'html' => $html
]);
