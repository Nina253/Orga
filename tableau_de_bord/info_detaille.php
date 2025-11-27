<?php
session_start();
if (!isset($_SESSION['client'])){
    header('Location: ../connecter.php');
    exit;
}
require '../bd.php';


$bdd = getBD();

$colonnes_disponibles = ['duree_travail', 'duree_sommeil' , 'duree_netflix', 'freq_sport'];

$colonne = isset($_GET['stat']) && in_array($_GET['stat'], $colonnes_disponibles) ? $_GET['stat'] : $colonnes_disponibles[0];

$stmt = $bdd->prepare("SELECT $colonne, date_hab FROM habitudes WHERE id_etu = ?");
$stmt->execute([$_SESSION['client']['id']]);
$resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);

$dates = [];
$valeurs = [];
foreach ($resultats as $row) {
    $dates[] = $row['date_hab'];
    $valeurs[] = (float)$row[$colonne];
}
?>



<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen" > 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>Info détaillée</title>
</head>
<body>
<?php include '../navbar.php'; ?>

<h1 id='stat'>Statistiques détaillées</h1>

<form method="get" id="formStat">
    <label for="stat">Choisir une statistique :</label>
    <select name="stat" id="stat" onchange="document.getElementById('formStat').submit();">
        <?php foreach($colonnes_disponibles as $col) : ?>
            <option value="<?= $col ?>" <?= $col == $colonne ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $col)) ?></option>
        <?php endforeach; ?>
    </select>
</form>

<?php if(empty($valeurs)) : ?>
    <p class="no-data-message">Il n'y a pas de données pour cette statistique.</p>
<?php else: ?>
    <div class='box_graph'>
        <canvas id="chartDetail" ></canvas>
    </div>
<?php endif; ?>

<script>
<?php if(!empty($valeurs)) : ?>
const ctx = document.getElementById('chartDetail').getContext('2d');
new Chart(ctx, {
    type: 'line',
    data: {
        labels: <?= json_encode($dates) ?>,
        datasets: [{
            label: "<?= ucfirst(str_replace('_', ' ', $colonne)) ?>",
            data: <?= json_encode($valeurs) ?>,
            borderColor: "blue",
            fill: true,
            backgroundColor: "rgba(0,123,255,0.2)",
            tension: 0.35
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
        scales: {
            y: { grid: { display: false }, ticks: { stepSize: 0.5 } },
            x: { grid: { display: false } }
        }
    }
});
<?php endif; ?>
</script>

</body>
</html>
