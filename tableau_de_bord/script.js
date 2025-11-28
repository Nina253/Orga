document.addEventListener('DOMContentLoaded', () => {
    const dates = <?php echo json_encode($dates); ?>;
    const notes = <?php echo json_encode($notes); ?>;
    const message = document.getElementsByClassName('no-data-message')[0];
    const chartCanvas = document.getElementById('myChart');

    if (dates.length === 0 || notes.length === 0) {
        chartCanvas.style.display = 'none';
        message.style.display = 'block';
        return;
    }

    new Chart(document.getElementById('myChart'), {
        type: 'line',
            data: { id_photo: id_photo },
            success: function(response) {
                console.log("Réponse serveur:", response);
                $("#currentPhoto").attr("src", "images/profiles/" + filename);
            },
            error: function() {
                alert("Erreur lors de la mise à jour de la photo.");
            }
        });
    });


    $("#formPrenom").submit(function(e) {
        e.preventDefault();
        update("prenom", $("#prenom").val(), "#msgPrenom");
    });

    $("#formNom").submit(function(e) {
        e.preventDefault();
        update("nom", $("#nom").val(), "#msgNom");
    });


});
