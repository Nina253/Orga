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

$show_average = isset($_GET['show_average']) && $_GET['show_average'] === 'on';


$stmt = $bdd->prepare("SELECT $colonne, date_hab FROM habitudes WHERE id_etu = ? ORDER BY date_hab ASC");
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


    <title>Info détaillée</title>
    <style>
        
        #formStat { display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 20px; flex-wrap: wrap;  /* background-color : red*/}
        .loader { font-size: 0.8em; color: gray; margin-left: 10px; display: none; }
    </style>
</head>
<body>
<?php include '../navbar.php'; ?>

<h1 id='stat' style='font-family: "Montserrat"'>Statistiques détaillées</h1>

<form method="get" id="formStat">
    <div>
        <label for="stat">Choisir une statistique :</label>
        <select name="stat" id="stat" onchange="document.getElementById('formStat').submit();">
            <?php foreach($colonnes_disponibles as $col) : ?>
                <option value="<?= $col ?>" <?= $col == $colonne ? 'selected' : '' ?>><?= ucfirst(str_replace('_', ' ', $col)) ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <?php if(!empty($valeurs)) : ?>
        
    <div>
        <label style="cursor: pointer;">
            <input type="checkbox" name="show_average" id="show_average" 
                   <?= $show_average ? 'checked' : '' ?> 
                   onchange="document.getElementById('formStat').submit();">
            Afficher la moyenne des autres utilisateurs
        </label>
    </div>
    <?php endif; ?>
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

const datesLabels = <?= json_encode($dates) ?>;
const valeursData = <?= json_encode($valeurs) ?>;
const currentStat = "<?= $colonne ?>";
const isAverageRequested = <?= $show_average ? 'true' : 'false' ?>;

let myChartInstance = null;


function affichage_graph(averageData = null) {
    const ctx = document.getElementById('chartDetail').getContext('2d');
        if (myChartInstance) {
        myChartInstance.destroy();
    }

    const datasets = [{
        label: "<?= ucfirst(str_replace('_', ' ', $colonne)) ?>",
        data: valeursData,
        borderColor: "blue",
        fill: true,
        backgroundColor: "rgba(0,123,255,0.2)",
        tension: 0.35,
        order: 2 
    }];

    if (averageData) {
        datasets.push({
            label: "Moyenne Cumulative",
            data: averageData,
            borderColor: "red",
            borderWidth: 2,
            borderDash: [4, 4], 
            fill: false,
            pointRadius: 0,
            tension: 0.3,
            order: 1
        });
    }


    myChartInstance = new Chart(ctx, {
        type: 'line',
        data: {
            labels: datesLabels,
            datasets: datasets
        },
        options: {
            responsive: false,
            maintainAspectRatio: false,
            plugins: { 
                legend: { display: averageData !== null } 
            }, 
            scales: {
                y: { grid: { display: false }, ticks: { stepSize: 0.5 } },
                x: { grid: { display: false } }
            }
        }
    });
}


function recup_moyenne() {
    $.ajax({
        url: 'calcul_moyenne_ajax.php',
        type: 'POST',
        data: {
            stat: currentStat,
            dates: JSON.stringify(datesLabels)
        },
        dataType: 'json',
        success: function(data) {            
            if (data.success) {
                affichage_graph(data.moyennes);
            } else {
                console.error("Erreur sur le calcule de la moyenne:", data.error);//er moyen
                affichage_graph(); 
            }
        },

        error: function(xhr, status, error) {
            console.error("Erreur AJAX:", error);
            affichage_graph();
        }
    });
}

if (isAverageRequested) {
    recup_moyenne();
} else {
    affichage_graph();
}

<?php endif; ?>
</script>

</body>
</html>