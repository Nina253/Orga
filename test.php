<?php session_start(); ?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Questionnaire Post-it</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="styles/style_navbar.css" type="text/css" media="screen" > 

    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: #e0e0e0;
            background-image: radial-gradient(#d0d0d0 1px, transparent 1px);
            background-size: 20px 20px;
            font-family: 'Patrick Hand', cursive; 
            margin: 0; padding: 0;
            min-height: 100vh;
            color: #2c3e50;
        }
        
        #question-container {
            margin-top : 50px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            padding: 20px;
            perspective: 1500px;
        }

        /* --- LE POST-IT --- */
        .qblock {
            background-color: #fff59d; /* Jaune Post-it */
            background-image: linear-gradient(135deg, #fff9c4, #fff176);
            
            padding: 50px 40px 50px 40px;
            width: 100%;
            max-width: 550px;
            position: relative;
            z-index: 1;
            
            transform: rotate(-2deg);
            transition: all 0.7s cubic-bezier(0.25, 0.8, 0.25, 1);
            box-sizing: border-box;

            /* Coin légèrement arrondi mais sans effet de pliage extrême */
            border-bottom-right-radius: 60px 5px; 
            
            /* Ombre simple autour du papier */
            box-shadow: 2px 2px 10px rgba(0,0,0,0.15);
        }

        /* J'AI SUPPRIMÉ LE BLOC .qblock::before ICI (C'était la bande d'ombre du bas) */

        /* --- LA PUNAISE ROUGE --- */
        .qblock::after {
            content: '';
            position: absolute;
            top: 15px;
            left: 50%;
            transform: translateX(-50%);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, #ff5f5f, #d32f2f);
            box-shadow: 0 2px 3px rgba(0,0,0,0.4), inset 0 -2px 5px rgba(0,0,0,0.2);
            z-index: 10;
        }

        /* --- ANIMATION D'ENVOL --- */
        .fly-away {
            transform: translateY(-120vh) rotate(15deg) rotateX(20deg) scale(0.8) !important;
            opacity: 0;
        }

        /* --- TEXTES & CHAMPS --- */
        #question-text { 
            font-size: 28px;
            font-weight: 400;
            margin-bottom: 35px; 
            line-height: 1.3; 
            text-align: center;
        }
        
        .barre, .lign { 
            width: 100%; padding: 10px 5px; margin-bottom: 30px; 
            border: none; 
            border-bottom: 2px solid #b0bec5; 
            background: transparent; 
            font-family: 'Patrick Hand', cursive; 
            font-size: 22px; 
            box-sizing: border-box; color: #333;
            transition: border-color 0.3s;
        }
        .barre:focus, .lign:focus { outline: none; border-bottom: 3px solid #d32f2f; }

        button { 
            background-color: #d32f2f;
            color: white; padding: 12px; 
            border: none; cursor: pointer; 
            font-family: 'Patrick Hand', cursive; 
            font-size: 24px;
            width: 100%; box-sizing: border-box;
            border-radius: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.2);
            transition: transform 0.2s, background-color 0.2s;
        }
        button:hover { background-color: #b71c1c; transform: translateY(-2px); }
        button:active { transform: translateY(1px); }

        .error { color: #d32f2f; font-weight: bold; font-size: 1.2em; }
        .success { color: #388e3c; font-weight: bold; text-align: center; font-size: 1.5em;}
        #progress { text-align: center; position: fixed; top: 10px; left:0; right:0; color: #666; font-size: 1.2em;}
        #status-message { text-align: center; margin-top: 20px; min-height: 30px;}
    </style>
</head>
<body>

    <?php if(file_exists('navbar.php')) include 'navbar.php'; ?>

    <div id="progress">Chargement...</div>

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
        let questionsList = [];
        let currentIndex = 0;
        let responses = {};

        $(document).ready(function() {
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

            // ANIMATION
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

            $.ajax({
                url: 'save.php',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(responses),
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#status-message').html("<h2 class='success'>✅ Merci ! Réponses enregistrées.</h2>");
                        window.location.href = 'tableau_de_bord/';
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