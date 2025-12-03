<?php
header('Content-Type: application/json');
session_start();

$response = ['success' => false, 'message' => 'Erreur inconnue.'];

try {

    require 'bd.php';
    
    $bdd=getBD(); 

    $id_etu = isset($_SESSION['client']['id']) ? $_SESSION['client']['id'] : 1; 
    

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (!$data) {
            throw new Exception("Données JSON invalides ou vides reçues.");
        }
        $deja_fait = isset($data['questionnaire_fait']) ? filter_var($data['questionnaire_fait'], FILTER_VALIDATE_BOOLEAN) : false;

        $colonnes = [
            'duree_travail', 'duree_reseaux', 'duree_netflix', 
            'duree_sommeil', 'job', 'nutrition', 'freq_sport', 
            'sante_mentale', 'parascolaire', 'acces_internet'
        ];

        $params = [];
        
        foreach ($colonnes as $col) {
            $params[":$col"] = array_key_exists($col, $data) ? $data[$col] : null; 
        }
        
        $params[':id_etu'] = $id_etu;
        $params[':id_scolarite'] = 1; 

        if ($deja_fait){

            $sql = "UPDATE habitudes SET 
                        duree_travail = :duree_travail, 
                        duree_reseaux = :duree_reseaux, 
                        duree_netflix = :duree_netflix, 
                        duree_sommeil = :duree_sommeil, 
                        job = :job, 
                        nutrition = :nutrition, 
                        freq_sport = :freq_sport, 
                        sante_mentale = :sante_mentale, 
                        parascolaire = :parascolaire, 
                        acces_internet = :acces_internet,
                        id_scolarite = :id_scolarite 
                    WHERE id_etu = :id_etu 
                    AND DATE(date_hab) = CURDATE()";
            
            $stmt = $bdd->prepare($sql);
            $stmt->execute($params); 

            $response = ['success' => true, 'message' => 'Données modifiées avec succès !'];
        }
        else{            
            $sql = "INSERT INTO habitudes 
                    (id_etu, id_scolarite,date_hab, duree_travail, duree_reseaux, duree_netflix, duree_sommeil, job, nutrition, freq_sport, sante_mentale, parascolaire, acces_internet) 
                    VALUES 
                    (:id_etu, :id_scolarite, NOW(), :duree_travail, :duree_reseaux, :duree_netflix, :duree_sommeil, :job, :nutrition, :freq_sport, :sante_mentale, :parascolaire, :acces_internet)";

            $stmt = $bdd->prepare($sql);
            $stmt->execute($params);

            $response = ['success' => true, 'message' => 'Données enregistrées avec succès !'];
        } 
    
    }else {
        $response['message'] = "Méthode " . $_SERVER['REQUEST_METHOD'] . " non autorisée.";
    }

} catch (Exception $e) {
    $response['success'] = false;
    $response['message'] = 'Erreur Serveur : ' . $e->getMessage();
}

echo json_encode($response);
?>