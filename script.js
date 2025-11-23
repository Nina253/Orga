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

        $(".photo-selector img").removeClass("selected");
        $(this).addClass("selected");

        $.post("update_photo.php", { photo: filename }, function(response) {
            console.log("Réponse serveur:", response);
            $("#currentPhoto").attr("src", "images/profiles/" + filename);
        }).fail(function() {
            alert("Erreur lors de la modification de la photo");
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
