<?php
session_start();
if (!isset($_SESSION['client'])){
    header('Location: ../connecter.php');
    exit;
}
require '../bd.php';
$bdd=getBD(); 
$hab= $bdd->prepare("SELECT duree_sommeil , date_hab ,duree_reseaux FROM habitudes WHERE id_etu = ?");
$hab->execute([$_SESSION['client']['id']]);
$boulot = $hab->fetchAll(PDO::FETCH_ASSOC);

$boulot = array_filter($boulot, function($row) {
    return !empty($row['duree_sommeil']) 
        || !empty($row['duree_reseaux']) 
        || !empty($row['date_hab']);
});

$dates = [];
$duree_sommeil = [];
$duree_reseaux = [];

foreach ($boulot as $row) {
    $dates[] = $row['date_hab'];
    $duree_sommeil[] = (float)$row['duree_sommeil'];
    $duree_reseaux[] = (float)$row['duree_reseaux'];
}

// Calcul des évolutions
$evoSommeil = null;
if (count($duree_sommeil) >= 2) {
    $first = $duree_sommeil[0];
    $last = end($duree_sommeil);
    if ($first > 0) {
        $evoSommeil = round((($last - $first) / $first) * 100, 1);
    }
}

$evoReseaux = null;
if (count($duree_reseaux) >= 2) {
    $first = $duree_reseaux[0];
    $last = end($duree_reseaux);
    if ($first > 0) {
        $evoReseaux = round((($last - $first) / $first) * 100, 1);
    }
}

$pointsForts = [];
$pointsFaibles = [];
$ameliorations = [];

// Points forts
if ($evoSommeil > 0) {
    $pointsForts[] = "Tu dors mieux qu'avant (+$evoSommeil%).";
}
if ($evoReseaux < 0) {
    $pointsForts[] = "Tu passes moins de temps sur les réseaux.";
}

// Points faibles
if ($evoSommeil < 0) {
    $pointsFaibles[] = "Ton sommeil diminue ($evoSommeil%).";
}
if ($evoReseaux > 0) {
    $pointsFaibles[] = "Tu passes plus de temps sur les réseaux (+$evoReseaux%).";
}

// Améliorations
if ($evoReseaux > 10) {
    $ameliorations[] = "Réduire le temps passé sur les réseaux sociaux.";
}
if ($evoSommeil < 0) {
    $ameliorations[] = "Essayer d'améliorer ton sommeil (coucher plus tôt, routine…).";
}

?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Tableau de bord</title>
</head>
<body>
    <?php include '../navbar.php'; ?>
    <h1 style='font-family: "Montserrat"'>Tableau de bord</h1> 
    <p style='font-family: serif; font-size: 20px; color: grey; text-align : center; word-spacing: 4px;'>Suis ton évolution personnelle au cours du temps sur ce tableau de bord</p> 
    <br> 
    <?php if (!empty($dates)){ ;?>

    <h2 style='font-family: "Arial Rounded MT Bold", sans-serif; text-decoration: underline;'> Graphiques d'évolution :</h2>

<div class="barre4">
    <h3>Graphique 1 : Evolution du sommeil</h3>
    <?php if (empty($duree_sommeil) || empty($dates)) : ?>
        <div class="no-data-message">Il n'y a pas de données pour le moment.</div>
    <?php endif; ?>
    
</div>
<canvas id="myChart1" class="graph"></canvas>

<div class="barre4">
    <h3>Graphique 2 : Evolution du temps passé sur les réseaux sociaux</h3>
    <?php if (empty($duree_reseaux) || empty($dates)) : ?>
        <div class="no-data-message">Il n'y a pas de données pour le moment.</div>
    <?php endif; ?>

<canvas id="myChart2" class="graph"></canvas>

<br></br>
<div id='bloc_tab'> <a href='info_detaille.php'>Accéder aux details</a></div>
<div class="result-container">

    <h2 style='font-family: "Arial Rounded MT Bold"; text-decoration: underline;'>
        Résultats :
    </h2>

    <ul class="result-list" style='font-family:"Liberation Serif"; font-size:18px;'>

        <?php if ($evoSommeil !== null): ?>
            <?php $colorSommeil = $evoSommeil < 0 ? "red" : ($evoSommeil > 0 ? "green" : "black"); ?>
            <li>
                Ton sommeil a évolué de 
                <strong style="color: <?= $colorSommeil ?>;">
                    <?= $evoSommeil ?>%
                </strong>.
            </li>
        <?php else: ?>
            <li>Pas assez de données pour analyser ton sommeil.</li>
        <?php endif; ?>


        <?php if ($evoReseaux !== null): ?>
            <?php $colorReseaux = $evoReseaux < 0 ? "green" : ($evoReseaux > 0 ? "red" : "black"); ?>
            <li>
                Ton temps sur les réseaux a évolué de 
                <strong style="color: <?= $colorReseaux ?>;">
                    <?= $evoReseaux ?>%
                </strong>.
            </li>
        <?php else: ?>
            <li>Pas assez de données pour analyser ton usage des réseaux.</li>
        <?php endif; ?>

    </ul>

    <div class="result-section">

        <strong>Points forts :</strong>
        <ul class="result-list">
            <?php foreach ($pointsForts as $pf): ?>
                <li style="color: green;">✔️ <?= $pf ?></li>
            <?php endforeach; ?>
        </ul>

        <strong>Points faibles :</strong>
        <ul class="result-list">
            <?php foreach ($pointsFaibles as $pf): ?>
                <li style="color: red;"> <?= $pf ?></li>
            <?php endforeach; ?>
        </ul>

    </div>

    <h2 style='font-family: "Arial Rounded MT Bold"; text-decoration: underline;'>
        Améliorations à prévoir :
    </h2>

    <ul class="result-list" style='font-family:"Liberation Serif"; font-size:18px;'>
        <?php foreach ($ameliorations as $am): ?>
            <li>➡️ <?= $am ?></li>
        <?php endforeach; ?>

        <?php if (empty($ameliorations)): ?>
            <li>👍 Pour l’instant tout semble bien aller !</li>
        <?php endif; ?>
    </ul>

    <?php }else{; ?>

        <p> Aucunes données n'a été enregistrées</p>
         <p> Veuillez répondre au questionnaire</p>
        <a href = "../questionnaire/questionnaire_v2.php" ><div class='bloc'> Questionnaire </div> </a>

        <?php }; ?>
</div>

<script>
const ctx1 = document.getElementById('myChart1').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: "Temps de sommeil (h)",
            data: <?php echo json_encode($duree_sommeil); ?>.map(Number),
            borderColor: "blue",
            fill: true,
            backgroundColor: "rgba(0,123,255,0.2)",
            tension: 0.35,
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false // cache la légende
            }
        },
        scales: {
            y: {
                grid: {
                    display: false // supprime le quadrillage
                },
                ticks: {
                    stepSize: 0.5 // pas de 0.5
                }
            },
            x: {
                grid: {
                    display: false // supprime le quadrillage vertical
                }
            }
        }
    }
});

const ctx2 = document.getElementById('myChart2').getContext('2d');
new Chart(ctx2, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: "Temps sur les réseaux (h)",
            data: <?php echo json_encode($duree_reseaux); ?>.map(Number),
            borderColor: "blue",
            fill: true,
            backgroundColor: "rgba(0,123,255,0.2)",
            tension: 0.35,
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false // cache la légende
            }
        },
        scales: {
            y: {
                grid: {
                    display: false // supprime le quadrillage
                },
                ticks: {
                    stepSize: 0.5 // pas de 0.5
                }
            },
            x: {
                grid: {
                    display: false // supprime le quadrillage vertical
                }
            }
        }
    }
});

</script>



    
    

</body>
</html>