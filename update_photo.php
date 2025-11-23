<?php
session_start();
include "bd.php";

if (!isset($_SESSION['client']['id'])) {
    echo "Utilisateur non connecté.";
    exit;
}

if (!isset($_POST['photo'])) {
    echo "Aucune photo reçue.";
    exit;
}

$photo = $_POST['photo'];
$id = $_SESSION['client']['id'];

// Vérifier que la photo existe bien dans le dossier
$path = "images/profiles/" . $photo;
if (!file_exists($path)) {
    echo "Fichier image introuvable.";
    exit;
}

try {
    $bdd = getBD();
    $req = $bdd->prepare("UPDATE etudiant SET photo = ? WHERE id_etu = ?");
    $req->execute([$photo, $id]);

    $_SESSION['client']= 
    echo "Photo mise à jour avec succès.";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
