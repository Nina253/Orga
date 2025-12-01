<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

include("../bd.php");
$bdd = getBD();
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // pour voir les erreurs PDO

// Vérification du token CSRF
if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
    echo json_encode(["success" => false, "error" => "Token invalide"]);
    exit;
}

// Récupération des données
$id_etu = $_SESSION['client']['id'] ?? null;
$date_evt = $_POST['date'] ?? '';
$nouv_freq = isset($_POST['nouv_freq']) ? (int)$_POST['nouv_freq'] : null;

if(!$id_etu || !$date_evt || $nouv_freq === null){
    echo json_encode(["success" => false, "error" => "Paramètres manquants"]);
    exit;
}

try {
    $startDate = new DateTime($date_evt);
    $endDate = (clone $startDate)->modify('+3 months'); // limite 3 mois
    $intervalSpec = 'P1D'; // quotidien par défaut

    if($nouv_freq === 1) $intervalSpec = 'P7D'; // hebdomadaire
    if($nouv_freq === 2) $intervalSpec = 'P1M'; // mensuel

    $interval = new DateInterval($intervalSpec);
    $period = new DatePeriod($startDate, $interval, $endDate->add($interval)); // inclut la dernière date

    // 1️⃣ Supprime les événements existants liés au questionnaire pour cet utilisateur
    $delete = $bdd->prepare("DELETE FROM calendrier WHERE id_etu = :id_etu AND titre = 'Remplir le questionnaire'");
    $delete->execute([":id_etu" => $id_etu]);

    // Transforme DatePeriod en tableau pour identifier la dernière date
    $dates = iterator_to_array($period);
    $lastDate = end($dates);

    // 2️⃣ Insère les nouveaux événements récurrents
    foreach($dates as $date){
        $dateStr = $date->format('Y-m-d');

        $titreEvt = 'Remplir le questionnaire';
        $descEvt = "Pense à remplir le questionnaire afin de suivre ton évolution";

        // Si c'est le dernier événement, ajouter un message spécial
        if($dateStr === $lastDate->format('Y-m-d')){
            $descEvt .= "Pense a remplir le questionnaire, aujourd'hui c'est le dernier rappel dans le calendrier.
            Si tu veux continuer de profiter des rappels dans le calendrier il faut que tu ailles dans modifier la frequence des enregistrements !";
        }

        $insert = $bdd->prepare("INSERT INTO calendrier (id_etu, date_evt, titre, description) VALUES (:id_etu, :date_evt, :titre, :description)");
        $insert->execute([
            ":id_etu" => $id_etu,
            ":date_evt" => $dateStr,
            ":titre" => $titreEvt,
            ":description" => $descEvt
        ]);
    }

    echo json_encode(["success" => true, "message" => "Fréquence mise à jour avec succès !"]);

} catch(Exception $e){
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
