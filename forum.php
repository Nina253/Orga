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

    <script>
    $(document).on('click', '.like-btn', function(){
    const $sujet = $(this).closest('.sujet');
    const id_sujet = $sujet.data('id');
    const $nb = $sujet.find('.nb-likes');
    $.post('like_sujet.php', { id_sujet: id_sujet }, function(rep){
        if(rep.success) $nb.text(rep.nb_likes);
        else alert(rep.message);
    }, 'json');
});

$(document).on('click', '.btn-commenter', function(){
    const $sujet = $(this).closest('.sujet');
    const id_sujet = $sujet.data('id');
    const contenu = $sujet.find('.commentaire-text').val().trim();
    if(contenu==="") return;
    $.post('ajouter_commentaire.php',{id_sujet,contenu},function(rep){
        if(rep.success){
            $sujet.find('.commentaires').html(rep.html);
            $sujet.find('.commentaire-text').val('');
        } else alert(rep.message);
    },'json');
});
</script>


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
<div class="sujet" data-id="<?php= $s['id'] ?>">
  <h3><?= ($s['titre']) ?></h3>
  <p><?= nl2br(($s['contenu'])) ?></p>
  <p>Posté par <?= ($s['prenom']." ".$s['nom']) ?> le <?= $s['date_creation'] ?></p><br>
  <div class="com">
  <span class="like-btn">❤️</span> <span class="nb-likes"><?= $s['nb_likes'] ?></span> likes 
  &nbsp; | 💬 <?= $s['nb_com'] ?> commentaires
</div>
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