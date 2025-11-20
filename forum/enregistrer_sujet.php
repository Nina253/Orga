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

// Vérification CSRF
if (!isset($_POST['token']) || $_POST['token'] !== $_SESSION['token']) {
    echo json_encode(['success'=>false, 'message'=>'Token invalide.']);
    exit;
}

// Récupérer les données
$titre = trim($_POST['titre'] ?? '');
$contenu = trim($_POST['contenu'] ?? '');
$id_etu = $_SESSION['client']['id'];

if ($titre === '' || $contenu === '') {
    echo json_encode(['success'=>false, 'message'=>'Veuillez remplir tous les champs.']);
    exit;
}

// Insertion
$stmt = $bdd->prepare("INSERT INTO sujets (titre, contenu, id_etu, date_creation) VALUES (?, ?, ?, NOW())");
$stmt->execute([$titre, $contenu, $id_etu]);

echo json_encode(['success'=>true, 'message'=>'Sujet publié avec succès !']);
?>