<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen">
    <title>Orga+</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    $(document).ready(function() {

        $.ajax({
            url: 'donnees/coeffs.json',
            dataType: 'json',
            success: function(coeffs) {
                console.log("AJAX success, coeffs =", coeffs);
                console.log("JSON chargé :", coeffs);

                const $pourcentageDisplay = $('#pourcentage');
                const $sommeilSlider = $('#sommeil');
                const $travailSlider = $('#travail');
                const $reseauxSlider = $('#reseaux');
                const $sportSlider = $('#sport');

                function calculerCapacite() {
                    const sommeil = parseFloat($sommeilSlider.val()) || 0;
                    const travail = parseFloat($travailSlider.val()) || 0;
                    const reseaux = parseFloat($reseauxSlider.val()) || 0;
                    const sport = parseFloat($sportSlider.val()) || 0;

                    // Calcul de la note prédite
                    let notePredite = (coeffs.noteSi0 || 0)
                                    + (coeffs.sommeil || 0) * sommeil
                                    + (coeffs.travail || 0) * travail
                                    + (coeffs.reseaux || 0) * reseaux
                                    + (coeffs.sport || 0) * sport;

                    // Limiter la note entre 0 et 100
                    notePredite = Math.min(Math.max(notePredite, 0), 100);

                    // Calcul du pourcentage de capacité
                    let capacite = Math.round((notePredite / 100) * 100);

                    $pourcentageDisplay.text(capacite + '%');
                }

                // Mettre à jour à chaque mouvement de slider
                $([$sommeilSlider, $travailSlider, $reseauxSlider, $sportSlider]).each(function() {
                    $(this).on('input', calculerCapacite);
                });

                // Calcul initial
                calculerCapacite();
            },
            error: function(xhr, status, error) {
                console.error("Erreur en chargeant les coefficients :", error);
                alert("Impossible de charger les coefficients. Vérifiez le chemin du JSON !");
            }
        });

    });
    </script>
</head>
<body>
<?php include "navbar.php" ?>

<h1 style='font-family: "Montserrat"'>Simulateur de performance</h1>
        <p class="txt_intro">Et si je changeais mes habitudes ? Simule rapidement l'impact de petits changements sur tes performances</p>

<div class="conteneur">
    <div class="text">


        <div class="simulateur">
            <div class="sliders">
                <label>Nombre d'heures de sommeil</label>
                <input type="range" min="0" max="11" value="7" class="slider" id="sommeil">
                <div class="scale"><span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
  <span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span></div>

                <label>Nombre d'heures de révisions</label>
                <input type="range" min="1" max="11" value="3" class="slider" id="travail">
<div class="scale"><span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
  <span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span></div>
                <label>Temps passé sur les réseaux sociaux</label>
                <input type="range" min="1" max="11" value="6" class="slider" id="reseaux">
<div class="scale"><span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
  <span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span></div>

                <label>Fréquence de sport</label>
                <input type="range" min="1" max="7" value="2" class="slider" id="sport">
                <div class="scale"><span>0</span><span>1</span><span>2</span><span>3</span><span>4</span><span>5</span>
  <span>6</span><span>7</span><span>8</span><span>9</span><span>10</span><span>11</span></div>

            </div>

            <div class="resultat">
                <h2 id="pourcentage">0%</h2>
                <p>C'est le pourcentage de tes capacités que tu exploites aujourd'hui.  
                Remplis notre questionnaire détaillé et applique nos conseils pour passer à 100 %  
                et libérer tout ton potentiel.</p>
            </div>
        </div>

    </div>
</div>
    <a class="bouton_retour" href="utilisateur/connecter.php">Obtenir des conseils personnalisés</a>

<?php include "navbarBas.php" ?>
</body>
</html>
