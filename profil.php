<?php


session_start();
include "bd.php";


if (!isset($_SESSION['client']['id'])) {
    header('Location: home.php');
exit; 
}

$bdd = getBD();
$id = $_SESSION['client']['id'];
$req = $bdd->prepare("SELECT prenom, nom, mail FROM etudiant WHERE id_etu = ?");
$req->execute([$id]);
$user = $req->fetch();

$images = glob("images/profiles/*.jpg"); 
?>

<html lang="fr">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="styles/styles.css">
<title>Mon Profil</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="script.js"></script>
<style>
.profile-container { display: flex; justify-content: space-between; align-items: flex-start; }
.profile-image { width: 150px; height: 150px; object-fit: cover; border-radius: 50%; }
.photo-selector img { width: 70px; height: 70px; object-fit: cover; cursor: pointer; margin: 5px; border: 2px solid transparent; border-radius: 50%; }
.photo-selector img.selected { border-color: green; }
</style>
</head>
<body>

<?php include "navbar.php" ?>

<div class="profile-container">

    <div class="profile-info">
        <h1>Mes Informations</h1>

        <!-- PRENOM -->
        <form class="pfl" id="formPrenom">
            <p>Votre prénom</p><br>
            <input class="barre2" type="text" id="prenom" value="<?= htmlspecialchars($user['prenom']) ?>">
            <button type="submit">Modifier</button>
            <span id="msgPrenom"></span>
        </form>

        <!-- NOM -->
        <form class="pfl" id="formNom">
            <p>Votre nom</p><br>
            <input class="barre2" type="text" id="nom" value="<?= htmlspecialchars($user['nom']) ?>">
            <button type="submit">Modifier</button>
            <span id="msgNom"></span>
        </form>
    </div>

    <!-- PHOTO DE PROFIL -->
    <div class="profile-photo">
        <h3>Photo de profil actuelle</h3>
        <img id="currentPhoto" src="images/profiles/<?= htmlspecialchars($user['photo'] ?? 'default.jpg') ?>" class="profile-image">

        <div class="photo-selector">
            <h4>Changer de photo</h4>
            <?php foreach($images as $img): 
                $imgName = basename($img);
            ?>
                <img src="<?= $img ?>" data-filename="<?= $imgName ?>" class="<?= ($user['photo'] == $imgName) ? 'selected' : '' ?>">
            <?php endforeach; ?>
        </div>
    </div>

</div>

</body>
</html>
