<?php
session_start();
require 'bd.php';
$bdd=getBD(); 
$hab= $bdd->prepare("SELECT duree_travail , date_hab FROM habitudes WHERE id_etu = ?");
$hab->execute([$_SESSION['client']['id']]);
$boulot = $hab->fetchAll(PDO::FETCH_ASSOC);
$dates = [];
$notes = [];

foreach ($boulot as $row) {
    $dates[] = $row['date_hab'];
    $notes[] = (float)$row['duree_travail']; // force conversion en nombre
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
    <title>Tableau de bord</title>
</head>
<body>
    <?php include 'navbar.php'; ?>
    <h1>Tableau de bord</h1>
    <p>Suis ton évolution personnelle au cours du temps sur ce tableau de bord</p>
        <h2> Graphiques d'évolution :</h2>
    <div class="barre4">
        <h3>Graphique 1 : Evolution des notes</h3>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<canvas id="myChart" style="margin-bottom:50px;"></canvas>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const dates = <?php echo json_encode($dates); ?>;
    const notes = <?php echo json_encode($notes); ?>;

    new Chart(document.getElementById('myChart'), {
        type: 'line',
        data: {
            labels: dates,
            datasets: [{
                label: "Notes en fonction des dates",
                data: notes.map(Number), // convertit en nombres
                borderWidth: 2,
                borderColor: "blue",
                fill: false,
                tension: 0.2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: false,
                    suggestedMin: Math.min(...notes) - 1,
                    suggestedMax: Math.max(...notes) + 1
                }
            }
        }
    });
});
</script>

    </div>
    <div class="barre4">
        <h3>Graphique 2 : Evolution d ?</h3>
        <img src="images/graphique_autre.png" alt="Graphique de " >   
    </div>
    <h2>Résultats : </h2>
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
</body>
</html>