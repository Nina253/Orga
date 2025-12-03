<?php session_start(); 
require "bd.php";
$bdd = getBd();

if (!isset($_SESSION['client']['id'])) {
    header("Location: home.php");
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
    <link rel="stylesheet" href="styles/style_navbar.css" type="text/css" media="screen" > 

    <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">
    
    <style>
        body {
            background-color: white;
            background-image: radial-gradient(#d0d0d0 1px, transparent 1px);
            background-size: 20px 20px;
            font-family: 'Kalam'; 
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
            height: 450px;
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
            margin-bottom: 50px; 
            margin-top: 20px;
            line-height: 1.3; 
            text-align: center;
        }
        
        .barre, .lign { 
            width: 100%; padding: 10px 5px; margin-bottom: 30px; 
            border: none; 
            border-bottom: 2px solid #b0bec5; 
            background: transparent; 
            font-family: 'Kalam'; 
            font-size: 22px; 
            box-sizing: border-box; color: #333;
            transition: border-color 0.3s;
        }
        .barre:focus, .lign:focus { outline: none; border-bottom: 3px solid #d32f2f; }

        button { 
            background-color: #d32f2f;
            color: white; padding: 12px; 
            border: none; cursor: pointer; 
            font-family: 'Kalam'; 
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
        /* --- Styles de la Modale --- */
        #modal-warning {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background-color: rgba(0, 0, 0, 0.7); /* Fond semi-transparent */
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1000; /* Assure que la modale est au-dessus de tout */
        }

        #modal-content {
            background: linear-gradient(to right,#5BA2FF,#C6FF8F );
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 400px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.5);
            font-family: 'Kalam', cursive;
            transform: scale(0.95);
            transition: transform 0.3s ease-out;
        }

        #modal-content h2 {
            color: #d32f2f;
            margin-top: 0;
            font-size: 1.8em;
        }

        #modal-buttons {
            margin-top: 25px;
            display: flex;
            justify-content: space-around;
        }

        #modal-buttons button {
            
            width: 45%;
            padding: 10px;
            border-radius: 20px;
            font-size: 1.1em;
            cursor: pointer;
            box-shadow: none; /* Simplifie le style des boutons modaux */
            transition: background-color 0.2s;
            transform: none;
        }

        #modal-cancel {
            background-color: #90a4ae;
        }
        #modal-cancel:hover {
            background-color: #78909c;
        }

        #modal-confirm {
            background-color: #d32f2f;
        }
        #modal-confirm:hover {
            background-color: #b71c1c;
        }
    </style>
</head>
<body>

    <?php // include 'navbar.php'; ?>

    <div id="progress">Chargement...</div>

    <div id="modal-warning" style="display: none;">
    <div id="modal-content">
        <h2>Attention !</h2>
        <p>Vous avez déjà rempli ce questionnaire aujourd'hui.</p>
        <p>Si vous CONTINUER vous modifirais les données actuelles</p>
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
                window.location.href = 'compte.php'; 
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