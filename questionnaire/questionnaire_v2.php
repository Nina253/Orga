<?php session_start(); 
require "../bd.php";
$bdd = getBd();

if (!isset($_SESSION['client']['id'])) {
    header("Location: ../home.php");
    exit;
}

$questionnaire_fait = False;
try{
$stmt = $bdd->prepare("SELECT COUNT(*) AS nb_reponses FROM habitudes WHERE id_etu = :id_etu AND DATE(date_hab) = CURDATE()");
$stmt->execute(['id_etu' => $_SESSION['client']['id']]);
$resultat = $stmt->fetch(PDO::FETCH_ASSOC);
$nombre_de_reponses = (int)$resultat['nb_reponses'];
if ($nombre_de_reponses > 0) {
            $questionnaire_fait = true;}
}catch(PDOException $e) {
    error_log("Erreur d'exécution de la requête : " . $e->getMessage());

}
        
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Questionnaire Post-it</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="style_questionnaire.css" type="text/css" media="screen" > 

    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    
   
</head>
<body>

    <?php  include '../navbar.php'; ?>

    <div id="progress">Chargement...</div>

    <div id="modal-warning" style="display: none;">
    <div id="modal-content">
        <h2>Attention !</h2>
        <p>Vous avez déjà rempli ce questionnaire aujourd'hui.</p>
        <p>Si vous CONTINUEZ, vous modifierez les données actuelles.</p>
        <div id="modal-buttons">
            <button id="modal-cancel">Annuler</button>
            <button id="modal-confirm" class="red-btn">Continuer</p>
        </div>
    </div>
</div>

    <div id="question-container">
        <div class="qblock" id="postit">
            <p id="question-text"></p>
            
            <form id="main-form">
                <div id="input-area"></div>
                <button type="submit" id="next-btn">Suivant</button>
            </form>
        </div>
    </div>

    <div id="status-message"></div>

    <script>
        const questionnaire_fait = <?php echo json_encode($questionnaire_fait); ?>;
        let questionsList = [];
        let currentIndex = 0;
        let responses = {};
        function startQuestionnaire() {
                $('#question-container').show();
                $('#modal-warning').hide();
                $.ajax({
                url: 'question.json',
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    questionsList = data;
                    if (questionsList.length > 0) {
                        displayQuestion();
                    } else {
                        $('#question-text').text("Aucune question trouvée.");
                         $('#progress').text("");
                    }
                },
                error: function() {
                    $('#question-text').text("Erreur : Impossible de charger question.json");
                    $('#progress').text("");
                }
            });
        }
            

        $(document).ready(function() {
            $('#question-container').hide();
            $('#progress').text(""); 
            //POP UP
            if (questionnaire_fait === true) {
                $('#modal-warning').show();
                
            } else {
                startQuestionnaire();
            }


            $('#modal-confirm').on('click', function() {
                startQuestionnaire();
            });

            $('#modal-cancel').on('click', function() {
                window.location.href = '../compte.php'; 
            });
        });

        function displayQuestion() {
            if (currentIndex < questionsList.length) {
                let q = questionsList[currentIndex];
                
                $('#question-text').text(q.texte);
                $('#progress').text(`Question ${currentIndex + 1} / ${questionsList.length}`);
                $('#status-message').text('');

                let html = '';
                if (q.type === 'nombre') {
                    html = `<input class="barre" type="number" id="answer-field" 
                            step="${q.step}" min="${q.min}" max="${q.max}" required placeholder="Écris ta réponse ici...">`;
                } else if (q.type === 'choix_unique') {
                    html = `<select class="lign" id="answer-field" required>
                                <option value="" disabled selected>-- Sélectionnez --</option>`;
                    q.options.forEach(opt => {
                        html += `<option value="${opt.valeur}">${opt.label}</option>`;
                    });
                    html += `</select>`;
                }

                $('#input-area').html(html);
                
                $('#next-btn').text(currentIndex === questionsList.length - 1 ? 'Terminer' : 'Suivant');

            } else {
                saveAll(); 
            }
        }

        $('#main-form').on('submit', function(e) {
            e.preventDefault();
            let val = $('#answer-field').val();
            
            if (val === null || val.trim() === '') {
                $('#status-message').text("Oops, tu as oublié de répondre !").addClass('error');
                return;
            }

            let qName = questionsList[currentIndex].name;
            if (!qName) { alert("Erreur JSON : champ 'name' manquant"); return; }

            responses[qName] = val; 

            $('#postit').addClass('fly-away');

            setTimeout(function() {
                currentIndex++;
                if (currentIndex < questionsList.length) {
                    displayQuestion(); 
                    $('#postit').removeClass('fly-away');
                } else {
                    saveAll();
                }
            }, 700);
        });

        function saveAll() {
            $('#question-container').hide();
            $('#progress').hide();
            $('#status-message').html("Enregistrement...").css('color', '#d32f2f');
            responses['questionnaire_fait'] = questionnaire_fait;

            $.ajax({
                url: 'save.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(responses),
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#status-message').html("<h2 class='success'>✅ Réponses enregistrées!</h2>");
                        window.location.href = '../tableau_de_bord/';
                    } else {
                        $('#status-message').html("<h2 class='error'>Erreur : " + res.message + "</h2>");
                    }
                },
                error: function(xhr) {
                    $('#status-message').html("<h2 class='error'>Erreur Serveur (Voir console)</h2>");
                    console.log(xhr.responseText);
                }
            });
        }
    </script>
</body>
</html>