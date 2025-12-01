<?php
session_start();
header("Content-Type: application/json; charset=UTF-8");

include("../bd.php");
$bdd = getBD();

// Vérification token CSRF
if(!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']){
    echo json_encode(["success" => false, "error" => "Token invalide"]);
    exit;
}

// Récupération et validation des champs
$id_etu = $_SESSION['client']['id'] ?? null;  // Assurez-vous que l'utilisateur est connecté
$date_evt = $_POST['date'] ?? '';
$titre = trim($_POST['titre_evt'] ?? '');
$description = trim($_POST['description_evt'] ?? '');

if(!$id_etu || !$date_evt || !$titre){
    echo json_encode(["success" => false, "error" => "Tous les champs obligatoires ne sont pas remplis"]);
    exit;
}

// Insertion dans la base
try{
    $sql = $bdd->prepare("
        INSERT INTO calendrier (id_etu, date_evt, titre, description)
        VALUES (:id_etu, :date_evt, :titre, :description)
    ");
    $sql->execute([
        ":id_etu" => $id_etu,
        ":date_evt" => $date_evt,
        ":titre" => $titre,
        ":description" => $description
    ]);

    echo json_encode(["success" => true]);
}catch(PDOException $e){
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
}
