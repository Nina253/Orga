

<!DOCTYPE html>

<html lang="fr">
<head>
<?php
include("../bd.php");
$bdd = getBD();
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="../styles/styles.css" type="text/css" media="screen"> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<title>Mon Calendrier</title>
</head>
<body>
<?php include "../navbar.php" ?>

<div class="container">
  <h1>Mon calendrier</h1>
  <p class="txt_intro">Voici un aperçu de ce que tu as à faire aujourd’hui</p>

  <div class="content">
    <div class="left">
      <?php include 'calendrier.php'; ?>
    </div>


<div class="right">
  <div class="today-info" id="page-today-info">
    <h3 id="page-selected-date-title">Aucune date sélectionnée</h3>
    <ul id="page-event-list">
      <li>chargement</li>
    </ul>
  </div>
  <div id="centrage_boutons">
  <a class="bouton_bleu" href="ajouter_evt.php">Ajoute des événements à ton calendrier</a>
  <a class="bouton_bleu" href="modifier_freq.php">Modifie la fréquence de tes enregistrements</a>
</div>
</div>

  </div>
</div>
<button class="bouton_retour" onclick="history.back()">Retour</button>

<footer id="footer_forum">
  <img class="logo" src="../images/logo.png" alt="logo">
  <a href="../nous.php">Qui sommes-nous ?</a>
</footer>

<script>
document.addEventListener('DOMContentLoaded', () => {
    // ID étudiant depuis PHP
    const idEtu = <?php echo json_encode($_SESSION['client']['id']); ?>;

    const pageTitle = document.getElementById('page-selected-date-title');
    const pageList = document.getElementById('page-event-list');

    function showPageEvents(dateKey) {
        const dateObj = new Date(dateKey);
        const today = new Date();
        const isToday = dateObj.toDateString() === today.toDateString();

        if (isToday) {
            pageTitle.textContent = "Aujourd’hui :";
        } else {
            const day = dateObj.getDate();
            const monthNames = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
            const month = monthNames[dateObj.getMonth()];
            const year = dateObj.getFullYear();
            pageTitle.textContent = `${day} ${month} ${year}`;
        }

        pageList.innerHTML = "<li>Chargement...</li>";

        fetch("/Orga/calendrier/events.php?action=get&date=" + dateKey + "&id_etu=" + idEtu)
        .then(r => r.json())
        .then(data => {
            pageList.innerHTML = "";
            if (!data || data.length === 0) {
                pageList.innerHTML = "<li>Aucun événement.</li>";
            } else {
                data.forEach(ev => {
                    const li = document.createElement("li");
                    li.innerHTML = `<strong>${ev.titre}</strong>${ev.description ? "<br>" + ev.description : ""}`;
                    pageList.appendChild(li);
                });
            }
        })
        .catch(err => {
            pageList.innerHTML = "<li>Erreur lors du chargement des événements.</li>";
            console.error(err);
        });
    }

    // Afficher par défaut les événements du jour
    const today = new Date();
    const todayKey = today.getFullYear() + "-" +
                     String(today.getMonth()+1).padStart(2,'0') + "-" +
                     String(today.getDate()).padStart(2,'0');
    showPageEvents(todayKey);

    // Rendre la fonction accessible globalement si nécessaire
    window.showPageEvents = showPageEvents;
});
</script>

</body>
</html>
