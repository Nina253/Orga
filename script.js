

$(document).ready(function(){

    console.log("JS chargé !");

    $(".insc").on("submit", function(e) {
        e.preventDefault();

        $.ajax({
            url: "connexion.php",
            type: "POST",
            data: $(this).serialize(),
            dataType: "json",
            success: function(reponse) {
                if (reponse.success) {
                    $("form").hide();
                    $("#message").css("font-size", "2rem").text("Connecté !");
                    setTimeout(() => { window.location.href = "index.php"; }, 2000);
            
                }
                 else {
                    $("#message-err").css("color", "red").text(reponse.message);
                }
            },
            error: function() {
                $("#message-err").css("color", "red").text("Problemes");
            }
        });
    });
});
