<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    session_start();
    include("bd.php");
    $bdd = getBD();
    $sql = "SELECT s.*, e.nom, e.prenom,
        (SELECT COUNT(*) FROM likes_sujets WHERE id = s.id) AS nb_likes,
        (SELECT COUNT(*) FROM commentaires WHERE id = s.id) AS nb_com
        FROM sujets s
        LEFT JOIN etudiant e ON e.id_etu = s.id_etu
        ORDER BY s.date_creation DESC";
    $sujets = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <title>Forum</title>

</head>
<body>
    <?php include "navbar.php" ?>
    <h1>Bienvenue sur le forum</h1>

    <?php if(isset($_SESSION["mail"])){
        echo '<a href="nouveau_sujet.php">Nouveau sujet</a>';
    }
    ?>
<div id="liste_sujets">
<?php foreach($sujets as $s): ?>
<div class="sujet" data-id="<?php= $s['id_sujet'] ?>">
  <h3><?= ($s['titre']) ?></h3>
  <p><?= nl2br(($s['contenu'])) ?></p>
  <small>Posté par <?= ($s['prenom']." ".$s['nom']) ?> le <?= $s['date_creation'] ?></small><br>
  <span class="like-btn">❤️</span> <span class="nb-likes"><?= $s['nb_likes'] ?></span> likes 
  &nbsp; | 💬 <?= $s['nb_com'] ?> commentaires
  <div class="commentaires"></div>
  <?php if(isset($_SESSION['id_etu'])): ?>
  <textarea class="commentaire-text" placeholder="Votre commentaire..."></textarea>
  <button class="btn-commenter">Commenter</button>
  <?php endif; ?>
</div>
<?php endforeach; ?>
</div>

</body>
</html>