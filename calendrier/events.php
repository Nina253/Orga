<?php
header("Content-Type: application/json; charset=UTF-8");

include("../bd.php");
$bdd = getBD();

// Vérification des paramètres
if (!isset($_GET['action']) || $_GET['action'] !== "get") {
    echo json_encode(["error" => "action manquante"]);
    exit;
}

if (!isset($_GET['date']) || !isset($_GET['id_etu'])) {
    echo json_encode(["error" => "paramètres manquants"]);
    exit;
}

$date = $_GET['date'];        // format YYYY-MM-DD
$id_etu = $_GET['id_etu'];    // VARCHAR(5) dans ta BD

// Requête : récupérer les événements de ce jour
$sql = $bdd->prepare("
    SELECT titre, description
    FROM calendrier
    WHERE date_evt = :date_evt
    AND id_etu = :id_etu
    ORDER BY id_evt ASC
");

$sql->execute([
    ":date_evt" => $date,
    ":id_etu"   => $id_etu
]);

$events = $sql->fetchAll(PDO::FETCH_ASSOC);

// Retour JSON
echo json_encode($events);
exit;
