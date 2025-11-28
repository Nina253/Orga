<?php include "../navbar.php" ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <?php
    include("../bd.php");
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
    		<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
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

            // ➤ 1 : Ouvrir la zone des commentaires si elle est fermée
            const zone = $('#commentaires-' + id_sujet);
            if(!zone.is(':visible')){
                zone.show();
            }

            // ➤ 2 : Ajouter le nouveau commentaire
            $('#liste-com-' + id_sujet).prepend(rep.html);

            // ➤ 3 : Vider le champ
            $('#txt-com-' + id_sujet).val('');
        } else {
            alert(rep.message);
        }
    }, "json");
}

function envoyerCommentaire(event, id_sujet){
    event.preventDefault();

    let input = $('#txt-com-' + id_sujet);
    let contenu = input.val().trim();

    if(contenu.length < 1){
        alert("Votre commentaire est vide.");
        return;
    }

    $.ajax({
        url: 'ajouter_commentaire.php',
        type: 'POST',
        data: { id_sujet: id_sujet, contenu: contenu },
        dataType: 'json',
        success: function(rep) {

            if(rep.success){

                // 🔥 Afficher message comme pour l’ajout d’un sujet
                $('#msg-com-' + id_sujet)
                    .css({color:'green'})
                    .text("Commentaire ajouté !");

                // 💬 Ajouter le commentaire directement
                $('#liste-com-' + id_sujet).prepend(rep.html);
                $('#nb-com-' + id_sujet).text(rep.nb_com);

                // 🧹 Vider le champ
                input.val('');

                // ⏱️ Effacer le message après 1 sec
                setTimeout(()=> $('#msg-com-' + id_sujet).text(""), 1000);

            } else {
                $('#msg-com-' + id_sujet)
                    .css({color:'red'})
                    .text(rep.message);
            }
        },
        error: function(jqXHR){
            alert("Erreur serveur !");
            console.log(jqXHR.responseText);
        }
    });
}


function supprimerCommentaire(id_com, id_sujet){
    if(!confirm("Supprimer ce commentaire ?")){
        return;
    }

    $.post("supprimer_commentaire.php", { id_com: id_com }, function(rep){
        if(rep.success){

            // supprimer du DOM
            $('#com-' + rep.id_com).remove();

            // 🔢 actualiser compteur
            $('#nb-com-' + id_sujet).text(rep.nb_com);

        } else {
            alert(rep.message);
        }
    }, "json")
    .fail(function(){
        alert("Erreur serveur");
    });
}

function supprimerSujet(id_sujet){
    if(!confirm("Voulez-vous vraiment supprimer ce sujet ?")){
        return;
    }

    // 🔒 Fermer zone commentaires AVANT suppression
    $('#commentaires-' + id_sujet).hide();

    $.post("supprimer_sujet.php", { id_sujet: id_sujet }, function(rep){
        if(rep.success){
            //  Supprimer le bloc HTML
            $('[data-id="'+id_sujet+'"]').remove();
        } else {
            alert(rep.message);
        }
    }, "json")
    .fail(function(){
        alert("Erreur serveur");
    });
}

    </script>

    <title>Forum</title>

</head>
<body>
    <h1 style='font-family: "Montserrat"'>Bienvenue sur le forum</h1>
    <p class="txt_intro" style='font-family: serif; font-size: 20px; color: grey; text-align : center; word-spacing: 4px;'>Discutez avec d’autres personnes de vos difficultés d’organisation</p>

    <?php if(isset($_SESSION["client"])){
    echo '<a id="bouton_bleu_nouveau_sujet" href="ajouter_sujet.php" style="font-family: \'Silk Serif\', serif; font-size:18px;">Nouveau sujet</a>';
    }
    ?>

<div id="liste_sujets">

<?php foreach($sujets as $s): ?>

<div class="sujet" data-id="<?= $s['id'] ?>">
    <?php if(isset($_SESSION["client"]) && $_SESSION["client"]['id'] == $s['id_etu']): ?>
    <button class="btn_supp_sujet" onclick="supprimerSujet(<?= $s['id'] ?>)">Supprimer le sujet</button>
<?php endif; ?>
    <h3><?= ($s['titre']) ?></h3>
  <p><?= ($s['contenu']) ?></p>
  <p>Posté par <?= ($s['prenom']." ".$s['nom']) ?> le <?= $s['date_creation'] ?></p><br>
  
  <div class="com">
    <button class="btn_like_comm" onclick="likeSujet(<?= $s['id'] ?>)">👍🏻 Like</button>
    <span id="nb-likes-<?= $s['id'] ?>"><?= $s['nb_likes'] ?></span> 

    | 

    <button class="btn_like_comm" onclick="toggleCommentaires(<?= $s['id'] ?>)">💬 Commentaires</button>
<span id="nb-com-<?= $s['id'] ?>"><?= $s['nb_com'] ?></span>
  
</div>
  <div id="commentaires-<?= $s['id'] ?>" class="commentaires" style="display:none;">
    
    <!-- Liste des commentaires chargés en Ajax -->
    <div class="liste-commentaires" id="liste-com-<?= $s['id'] ?>"></div>

    <!-- Formulaire pour écrire -->
    <?php if(isset($_SESSION["client"])): ?>
    <textarea id="txt-com-<?= $s['id'] ?>" placeholder="Votre commentaire..."></textarea>
    <button onclick="envoyerCommentaire(event, <?= $s['id'] ?>)">Envoyer</button>
    <div id="msg-com-<?= $s['id'] ?>" class="msg"></div>

<?php endif; ?>
</div>
  
</div>
<?php endforeach; ?>

<footer id="footer_forum">
    <img class="logo" src="../images/logo.png" alt="logo">
    <a href="../nous.php">Qui sommes-nous ?</a>
</body>

</html>