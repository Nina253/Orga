<!DOCTYPE html>
<html lang="fr">
    <head>
		<meta charset="UTF-8">
		<link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
        
        <title>Orga+</title>
    </head>
    <body>
    	
    <?php include "navbar.php" ?>


	<h1>Simulateur de performance</h1>
	<div class="conteneur">
	<div class="text">
	<h3>Et si je changeais mes habitudes ? Simule rapidement l'impact de petits changements sur tes performances</h3>
    <h1>Simulateur de performance</h1>

<div class="simulateur">
  <div class="sliders">
    <label>Nombre d'heures de sommeil</label>
    <input type="range" min="1" max="11" value="7" class="slider">
    <div class="scale">1 2 3 4 5 6 7 8 9 10 11</div>

    <label>Nombre d'heures de révisions</label>
    <input type="range" min="1" max="11" value="3" class="slider">
    <div class="scale">1 2 3 4 5 6 7 8 9 10 11</div>

    <label>Temps passé sur les réseaux sociaux</label>
    <input type="range" min="1" max="11" value="6" class="slider">
    <div class="scale">1 2 3 4 5 6 7 8 9 10 11</div>

    <label>Fréquence de sport</label>
    <input type="range" min="1" max="7" value="2" class="slider">
    <div class="scale">1 2 3 4 5 6 7</div>
  </div>

  <div class="resultat">
    <h2>60%</h2>
    <p>C'est le pourcentage de tes capacités que tu exploites aujourd'hui.  
    Remplis notre questionnaire détaillé et applique nos conseils pour passer à 100 %  
    et libérer tout ton potentiel.</p>
  </div>
</div>

    <a class="bouton_bleu" href="questionnaire_nom.php">Obtenir des conseils personnalisés</a>
	</div>	

	</div>
	<footer>
	<img class="logo" src="images/logo.png" alt="logo" >
	
	<a href="nous.html" >Qui sommes nous</a>
	</footer>
    </body>
</html>
