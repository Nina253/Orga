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
$dates = [];
$duree_sommeil = [];
$duree_reseaux = [];

foreach ($boulot as $row) {
    $dates[] = $row['date_hab'];
    $duree_sommeil[] = (float)$row['duree_sommeil'];
    $duree_reseaux[] = (float)$row['duree_reseaux']; // force conversion en nombre
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
    <h1>Tableau de bord</h1>
    <p>Suis ton évolution personnelle au cours du temps sur ce tableau de bord</p>
        <h2> Graphiques d'évolution :</h2>

<div class="barre4">
    <h3>Graphique 1 : Evolution du sommeil</h3>

    <?php if (empty($duree_sommeil) || empty($dates)) : ?>
        <div class="no-data-message">Il n'y a pas de données pour le moment.</div>
    <?php else : ?>
        <canvas id="myChart1"></canvas>
    <?php endif; ?>

</div>

<div class="barre4" style="margin-top: 80px;">
        <h3>Graphique 2 : Evolution du temps passé sur les réseaux sociaux</h3>
    <?php if (empty($duree_reseaux) || empty($dates)) : ?>
        <div class="no-data-message">Il n'y a pas de données pour le moment.</div>
    <?php endif; ?>
<canvas id="myChart2"></canvas>


    <h2>Résultats : </h2>

    <div class='bloc'> <a href='info_detaille.php'>Accéder aux details</a></div>
    <ul>
        <li> Augmentation des notes</li>
        <li> Votre sommeil a évolué de ..%</li>
        <li> Point fort : </li>
        <li> Point faible : </li>
    </ul>
    <h2>Améliorations à prévoire :</h2>
    <ul>
        <li> Diminuer le temps passé sur le téléphone</li>
    </ul>




<script>
const ctx1 = document.getElementById('myChart1').getContext('2d');
new Chart(ctx1, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($dates); ?>,
        datasets: [{
            label: "Temps de travail (h)",
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
            label: "Temps de travail (h)",
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