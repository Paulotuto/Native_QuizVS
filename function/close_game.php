<?php


include 'gestionBD.inc.php';
include 'functions.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['game_id'])) {
        $game_id = $_POST['game_id'];
        closeGame($game_id);
    }
}





function closeGame($game_id) {

    $connex = connexionBd();
    
    $checkSql = "SELECT * FROM games WHERE id = :game_id";
    $checkStmt = $connex->prepare($checkSql);
    $checkStmt->execute(['game_id' => $game_id]);
    $game = $checkStmt->fetch();

    if ($game) {
        
        $deleteSql = "DELETE FROM games WHERE id = :game_id";
        $deleteStmt = $connex->prepare($deleteSql);
        $deleteStmt->execute(['game_id' => $game_id]);
    }
}

header('Location: ../pages/accueil.php');
exit();
?>
