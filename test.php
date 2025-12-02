<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="styles/styles.css" type="text/css" media="screen" > 
    <title>Questionnaire</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .qblock { margin-bottom: 200px; margin-top : 75px }
        #question-text { font-size: 18px; font-weight: bolder; margin-bottom: 15px; }
        .barre, .lign { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #bb3e3eff; border-radius: 5px; box-sizing: border-box; }
        button { background-color: #007BFF; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; }
        button:hover { background-color: #0056b3; }
        .error { color: red; font-weight: bold; }
        .success { color: green; font-weight: bold; text-align: center; }
        #progress { margin-bottom: 10px; color: #a93232ff; font-size: 0.9em; }
        #status-message{margin-top : 100px ; background-color: red;}
    </style>
</head>
<body>
    <?php  include 'navbar.php' ;?>

    <div id="progress">Chargement...</div>

    <div id="question-container">
        <div class="qblock">
            <p id="question-text"></p>
            <form id="main-form">
                <div id="input-area"></div>
                <br>
                <button type="submit" id="next-btn">Suivant</button>
            </form>
        </div>
    </div>

    <div id="status-message"></div>

    <script>
        let questionsList = [];
        let currentIndex = 0;
        let responses = {};

        // 1. Charger le JSON
        $(document).ready(function() {
            $.ajax({
                url: 'question.json', // Vérifiez bien que le fichier s'appelle question.json ou questions.json
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    questionsList = data;
                    if (questionsList.length > 0) {
                        displayQuestion();
                    } else {
                        $('#question-text').text("Aucune question trouvée.");
                    }
                },
                error: function() {
                    $('#question-text').text("Erreur : Impossible de charger question.json");
                }
            });
        });

        // 2. Afficher la question
        function displayQuestion() {
            if (currentIndex < questionsList.length) {
                let q = questionsList[currentIndex];
                
                $('#question-text').text(`${currentIndex + 1}. ${q.texte}`);
                $('#progress').text(`Question ${currentIndex + 1} sur ${questionsList.length}`);
                $('#status-message').text('');

                let html = '';
                if (q.type === 'nombre') {
                    html = `<input class="barre" type="number" id="answer-field" 
                            step="${q.step}" min="${q.min}" max="${q.max}" required placeholder="Entrez un nombre">`;
                } else if (q.type === 'choix_unique') {
                    html = `<select class="lign" id="answer-field" required>
                                <option value="" disabled selected>-- Choisir --</option>`;
                    q.options.forEach(opt => {
                        html += `<option value="${opt.valeur}">${opt.label}</option>`;
                    });
                    html += `</select>`;
                }

                $('#input-area').html(html);
                
                if (currentIndex === questionsList.length - 1) {
                    $('#next-btn').text('Terminer et Enregistrer');
                } else {
                    $('#next-btn').text('Suivant');
                }

            } else {
                saveAll(); 
            }
        }

        // 3. Gérer le clic sur Suivant
        $('#main-form').on('submit', function(e) {
            e.preventDefault();
            let val = $('#answer-field').val();
            
            if (val === null || val.trim() === '') {
                $('#status-message').text("Veuillez répondre à la question.").addClass('error');
                return;
            }

            // --- CORRECTION MAJEURE ICI ---
            // On utilise le "name" du JSON (ex: duree_travail) au lieu de l'ID
            let qName = questionsList[currentIndex].name;
            
            if (!qName) {
                alert("Erreur JSON : La question n'a pas de champ 'name'");
                return;
            }

            responses[qName] = val; 
            // -----------------------------

            currentIndex++;
            displayQuestion();
        });

        // 4. Envoi AJAX
        function saveAll() {
            $('#question-container').hide();
            $('#progress').hide();
            $('#status-message').html("Enregistrement en cours...").css('background-color', 'transparent');

            $.ajax({
                url: 'save.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(responses),
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#status-message').html("<h2 class='success'>✅ Merci ! Réponses enregistrées.</h2>");
                    } else {
                        $('#status-message').html("<h2 class='error'>Erreur : " + res.message + "</h2>");
                    }
                },
                error: function(xhr, status, error) {
                    console.log(xhr.responseText); // Pour voir l'erreur PHP dans la console
                    $('#status-message').html("<h2 class='error'>Erreur de connexion serveur.</h2>");
                }
            });
        }
    </script>
</body>
</html>