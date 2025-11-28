<?php
session_start();
include "bd.php";

$bdd = getBD(); 

$id = $_SESSION['client']['id'];

$field = $_POST['field'] ?? null;
$value = $_POST['value'] ?? null;

$allowed = ["prenom", "nom", "mail"];

if (!in_array($field, $allowed)) {
    echo "Erreur : champ non autorisé.";
    exit;
}

if (empty($value)) {
    echo "Veuillez remplir le champ.";
    exit;
}

$req = $bdd->prepare("UPDATE etudiant SET $field = ? WHERE id_etu = ?");
$req->execute([htmlspecialchars($value), $id]);

echo "Modification enregistrée !";
