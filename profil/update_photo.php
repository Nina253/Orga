<?php
session_start();
include "../bd.php";

if (!isset($_SESSION['client']['id'])) {
    echo "Utilisateur non connecté.";
    exit;
}

if (!isset($_POST['id_photo'])) {
    header('Location: profil.php');
    exit;
}

$id_photo = $_POST['id_photo'];
$id = $_SESSION['client']['id'];



try {
    $bdd = getBD();
    $requete = $bdd->prepare('UPDATE `etudiant` SET `id_photo` = :id_photo WHERE `id_etu` = :id_etu');

$succes = $requete->execute([
    'id_photo' => $id_photo,
    'id_etu'   => $id
]);
    $req = $bdd->prepare("SELECT url FROM photo WHERE id_photo = :id_photo");
    $req->execute(['id_photo' => $id_photo]);
    $result = $req->fetch(PDO::FETCH_ASSOC);


    $_SESSION['client']['id_photo'] = $id_photo;
    $_SESSION['client']['url'] = $result['url'];
    echo "Photo mise à jour avec succès.";
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}
