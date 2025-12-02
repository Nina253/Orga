<?php if(!empty($valeurs)) : ?>

// --- 1. Préparation des données initiales (PHP vers JS) ---
const datesLabels = <?= json_encode($dates) ?>;
const valeursData = <?= json_encode($valeurs) ?>;
const currentStat = "<?= $colonne ?>";
const isAverageRequested = <?= $show_average ? 'true' : 'false' ?>;

let myChartInstance = null;

// --- 2. Fonction principale pour dessiner le graphique ---
function renderChart(averageData = null) {
    const ctx = document.getElementById('chartDetail').getContext('2d');
    
    // Si un graphique existe déjà, on le détruit pour le redessiner proprement
    if (myChartInstance) {
        myChartInstance.destroy();
    }

    // Dataset de base (bleu)
    const datasets = [{
        label: "<?= ucfirst(str_replace('_', ' ', $colonne)) ?>",
        data: valeursData,
        borderColor: "blue",
        fill: true,
        backgroundColor: "rgba(0,123,255,0.2)",
        tension: 0.35,
        order: 2 // Pour que la ligne bleue soit au-dessus ou en-dessous selon préférence
    }];

    // Si on a reçu des données de moyenne via AJAX, on ajoute le dataset rouge
    if (averageData) {
        datasets.push({
            label: "Moyenne Cumulative",
            data: averageData,
            borderColor: "red",
            borderWidth: 2,
            borderDash: [5, 5], // Ligne pointillée
            fill: false,
            pointRadius: 0,
            tension: 0.3,
            order: 1
        });
    }

    // Création du graphique Chart.js
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
                legend: { display: averageData !== null } // Affiche la légende seulement si on a 2 lignes
            }, 
            scales: {
                y: { grid: { display: false }, ticks: { stepSize: 0.5 } },
                x: { grid: { display: false } }
            }
        }
    });
}

// --- 3. Fonction AJAX pour récupérer la moyenne ---
function fetchAverageData() {
    const loader = document.getElementById('loadingMsg');
    loader.style.display = 'inline'; // Afficher "Calcul en cours..."

    // Préparation des données POST
    const formData = new FormData();
    formData.append('stat', currentStat);
    formData.append('dates', JSON.stringify(datesLabels)); // On envoie la liste des dates affichées

    fetch('calcul_moyenne_ajax.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        loader.style.display = 'none';
        
        if (data.success) {
            // Succès : on redessine le graph avec la liste des moyennes reçue
            renderChart(data.moyennes);
        } else {
            console.error("Erreur backend:", data.error);
            renderChart(); // On dessine sans la moyenne si erreur
        }
    })
    .catch(err => {
        loader.style.display = 'none';
        console.error("Erreur AJAX:", err);
        renderChart();
    });
}

// --- 4. Logique de démarrage ---
if (isAverageRequested) {
    // Si la case est cochée, on lance l'AJAX
    fetchAverageData();
} else {
    // Sinon, on dessine juste le graph normal immédiatement
    renderChart();
}

<?php endif; ?>