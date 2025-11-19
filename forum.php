<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include("bd.php");
    $bdd = getBD();
    $sql = "SELECT s.*, e.nom, e.prenom,
        (SELECT COUNT(*) FROM likes_sujets WHERE sujet_id = s.id) AS nb_likes,
        (SELECT COUNT(*) FROM commentaires WHERE sujet_id = s.id) AS nb_com
        FROM sujets s
        LEFT JOIN etudiant e ON e.id_etu = s.id_etu
        ORDER BY s.date_creation DESC";
    $sujets = $bdd->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    ?>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
    function likeSujet(id_sujet){
    $.post("like_sujet.php", { id_sujet: id_sujet }, function(rep){
        if(rep.success){
            $('#nb-likes-' + id_sujet).text(rep.nb_likes);
        }else{
            alert(rep.message);
        }
    }, "json");
}
    function toggleCommentaires(id_sujet){
        const zone = $('#commentaires-' + id_sujet);
        if(zone.is(':visible')){
        zone.hide();
        return;
        }
        $.post("charger_commentaires.php", { id_sujet: id_sujet }, function(rep){
            if(rep.success){
                $('#liste-com-' + id_sujet).html(rep.html);
                zone.show();
            } else {
                alert(rep.message);
            }
    }, "json");
}
    function ajouterCommentaire(id_sujet){
    const contenu = $('#txt-com-' + id_sujet).val().trim();

    if(contenu === ""){
        alert("Commentaire vide.");
        return;
    }

    $.post("ajouter_commentaire.php", { id_sujet: id_sujet, contenu: contenu }, function(rep){
        if(rep.success){
            $('#liste-com-' + id_sujet).html(rep.html);
            $('#txt-com-' + id_sujet).val('');
        } else {
            alert(rep.message);
        }
    }, "json");
}


    </script>

    <title>Forum</title>

</head>
<body>
    <?php include "navbar.php" ?>
    <h1>Bienvenue sur le forum</h1>
    <p class="txt_intro">Discutez avec d’autres personnes de vos difficultés d’organisation</p>

    <?php if(isset($_SESSION["mail"])){
        echo '<a href="nouveau_sujet.php">Nouveau sujet</a>';
    }
    ?>

<div id="liste_sujets">

<?php foreach($sujets as $s): ?>
<div class="sujet" data-id="<?= $s['id'] ?>">
    <h3><?= ($s['titre']) ?></h3>
  <p><?= ($s['contenu']) ?></p>
  <p>Posté par <?= ($s['prenom']." ".$s['nom']) ?> le <?= $s['date_creation'] ?></p><br>
  
  <div class="com">
    <button class="btn_like_comm" onclick="likeSujet(<?= $s['id'] ?>)">👍🏻 Like</button>
    <span id="nb-likes-<?= $s['id'] ?>"><?= $s['nb_likes'] ?></span> 

    | 

    <button class="btn_like_comm" onclick="toggleCommentaires(<?= $s['id'] ?>)">💬 Commentaires</button>
    <span><?= $s['nb_com'] ?></span>
  
</div>
  <div id="commentaires-<?= $s['id'] ?>" class="commentaires" style="display:none;">
    
    <!-- Liste des commentaires chargés en Ajax -->
    <div class="liste-commentaires" id="liste-com-<?= $s['id'] ?>"></div>

    <!-- Formulaire pour écrire -->
    <?php if(isset($_SESSION["mail"])): ?>
    <textarea id="txt-com-<?= $s['id'] ?>" placeholder="Votre commentaire..."></textarea>
    <button onclick="ajouterCommentaire(<?= $s['id'] ?>)">Envoyer</button>
<?php endif; ?>
</div>
  
</div>
<?php endforeach; ?>



</body>
</html>