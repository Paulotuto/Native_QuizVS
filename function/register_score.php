<?php
header('Content-Type: application/json');

session_start();
include_once '../function/gestionBD.inc.php';
include '../function/functions.php';

define('PLAYER_1_SCORE_COLUMN', 'player1_score');
define('PLAYER_2_SCORE_COLUMN', 'player2_score');

function enregistrerScore($gameID, $score)
{
    $connex = connexionBd();

    if ($connex) {
        $playerColumn = player1or2($gameID, recupIdfromUsername($_SESSION['username']));

        if ($playerColumn === 'player1_score' || $playerColumn === 'player2_score') {
            $sql = "UPDATE `games`
                    SET `$playerColumn` = :score
                    WHERE id = :id";

            $checkStmt = $connex->prepare($sql);

            try {
                $checkStmt->execute(['id' => $gameID, 'score' => $score]);
                $response = array('success' => true, 'message' => 'Mise à jour réussie.');
            } catch (PDOException $e) {
                $response = array('success' => false, 'message' => 'Erreur lors de la mise à jour de la base de données.');
            }
        } else {
            $response = array('success' => false, 'message' => 'Nom de colonne du joueur non valide.');
        }
    } else {
        $response = array('success' => false, 'message' => 'Erreur de connexion à la base de données.');
    }

    echo json_encode($response);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $game_id = $_POST['game_id'];
    $score = $_POST['score'];
    enregistrerScore($game_id, $score);
} else {
    $response = array('success' => false, 'message' => 'Requête non valide.');
    echo json_encode($response);
}
?>
