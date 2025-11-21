$(document).ready(function() {

    function update(field, value, msgElement) {
        $.ajax({
            url: "modif.php",
            type: "POST",
            data: {
                field: field,
                value: value
            },
            success: function(response) {
                $(msgElement).html(response).css("color", "green");
            },
            error: function() {
                $(msgElement).html("Erreur lors de la mise à jour.").css("color", "red");
            }
        });
    }
    $(".photo-selector img").click(function() {
        let filename = $(this).data("filename");

        // Mise en surbrillance
        $(".photo-selector img").removeClass("selected");
        $(this).addClass("selected");

        // AJAX pour modifier la photo de profil
        $.post("update_photo.php", { photo: filename }, function(response) {
            console.log("Réponse serveur:", response);
            $("#currentPhoto").attr("src", "images/profiles/" + filename);
        }).fail(function() {
            alert("Erreur lors de la modification de la photo");
        });
    });


    // Prénom
    $("#formPrenom").submit(function(e) {
        e.preventDefault();
        update("prenom", $("#prenom").val(), "#msgPrenom");
    });

    // Nom
    $("#formNom").submit(function(e) {
        e.preventDefault();
        update("nom", $("#nom").val(), "#msgNom");
    });

    // Mail
    $("#formMail").submit(function(e) {
        e.preventDefault();
        update("mail", $("#mail").val(), "#msgMail");
    });
});
