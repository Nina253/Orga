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

        let id_photo = $(this).data("id");      
        let filename = $(this).data("filename"); 
        $(".photo-selector img").removeClass("selected");
        $(this).addClass("selected");

        $.ajax({
            url: "update_photo.php",
            type: "POST",
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
