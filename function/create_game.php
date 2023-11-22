<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['player1']) && isset($_POST['player2'])) {
        $player1 = $_POST['player1'];
        $player2 = $_POST['player2'];

    }
}
include 'gestionBD.inc.php';
include 'functions.php';


$connex = connexionBd();

$usernamePlayer1 = $player1;
$usernamePlayer2 = $player2;


$idPlayer1 = recupIdfromUsername($usernamePlayer1);
$idPlayer2 = recupIdfromUsername($usernamePlayer2);

if (!gameExist($idPlayer1, $idPlayer2)) {
    $sql = "INSERT INTO `games`(`player1_id`, `player2_id`, `player1_score`, `player2_score`, `status`) VALUES (:player1_id, :player2_id, :player1_score, :player2_score, :status)";
    $stmt = $connex->prepare($sql);

    $stmt->execute(['player1_id' => $idPlayer1, 'player2_id' => $idPlayer2, 'player1_score' => 0, 'player2_score' => 0, 'status' => 'en attente']);

    
header('Location: ../pages/accueil.php');
exit();
} else{
    header('Location: ../pages/accueil.php');
exit();
}


