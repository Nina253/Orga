<?php
session_start();


if (!isset($_SESSION['client'])) {
    echo json_encode(['success' => false, 'error' => 'Non autorisé']);
    exit;
}

if (!isset($_POST['stat']) || !isset($_POST['dates'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Paramètres manquants']);
    exit;
}

require '../bd.php'; 

$bdd = getBD();
$colonne = $_POST['stat'];
$dates_demandees = json_decode($_POST['dates'], true); 

if (!is_array($dates_demandees)) {
    echo json_encode(['success' => false, 'error' => 'Format des dates invalide']);
    exit;
}

$colonnes_disponibles = ['duree_travail', 'duree_sommeil', 'duree_netflix', 'freq_sport'];
if (!in_array($colonne, $colonnes_disponibles)) {
    echo json_encode(['success' => false, 'error' => 'Statistique non valide']);
    exit;
}

try {
    $stmt = $bdd->prepare("
        SELECT date_hab, AVG($colonne) as moyenne_jour 
        FROM habitudes 
        GROUP BY date_hab 
        ORDER BY date_hab ASC
    ");
    $stmt->execute();
    $resultats_bd = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $map_moyennes = [];
    foreach ($resultats_bd as $row) {
        $map_moyennes[$row['date_hab']] = (float)$row['moyenne_jour'];
    }

    $moyennes_output = [];

    foreach ($dates_demandees as $date) {
        if (isset($map_moyennes[$date])) {
            $moyennes_output[] = round($map_moyennes[$date], 2);
        } else {
            $moyennes_output[] = 0; 
        }
    }

    echo json_encode(['success' => true, 'moyennes' => $moyennes_output]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>