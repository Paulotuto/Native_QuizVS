<?php 


function recupIdfromUsername($username){
    $connex = connexionBd();

    if ($connex) {
        
        $sql = "SELECT id FROM `utilisateurs` WHERE `username` = :username";
        $checkStmt = $connex->prepare($sql);
        $checkStmt->execute(['username' => $username]);
        $result = $checkStmt->fetch();

        return $result['id'];

        
    } 
}


function recupUsernamefromId($id){
    $connex = connexionBd();

    if ($connex) {
        
        $sql = "SELECT username FROM `utilisateurs` WHERE `id` = :id";
        $checkStmt = $connex->prepare($sql);
        $checkStmt->execute(['id' => $id]);
        $result = $checkStmt->fetch();

        return $result['username'];

        
    } 
}

function gameExist($idPlayer1,$idPlayer2){
    $connex = connexionBd();

    if ($connex) {
        
        $sql = "SELECT count(*) as nb FROM `games` WHERE `player1_id` = :idP1 AND `player2_id` = :idP2";
        $checkStmt = $connex->prepare($sql);
        $checkStmt->execute(['idP1' => $idPlayer1,'idP2'=> $idPlayer2]);
        $result = $checkStmt->fetch();

        return ($result['nb']!=0);

        
    } 

}

function acceptgame($id){
    $connex = connexionBd();

    if ($connex) {
        
        $sql = "UPDATE `games`
        SET `status` = 'en cours'
        WHERE id = :id";
        $checkStmt = $connex->prepare($sql);
        $checkStmt->execute(['id' => $id]);
        $checkStmt->fetch();
        
    } 

}

function allPlayersEvenMe(){
    $sql = "SELECT * FROM utilisateurs where username != :username";
    $connex = connexionBd();
    $stmt = $connex->prepare($sql);

    if ($stmt->execute(['username' => $_SESSION['username']])) {
        $players = $stmt->fetchAll();
    } else {
        $error = "Erreur de connexion à la base de données.";
    }
    return $players;
}

function gamesSend(){
    $connex = connexionBd();
    $sql = "SELECT * FROM games where player1_id = :id AND `status` = 'en attente'";
    $stmt = $connex->prepare($sql);

    if ($stmt->execute(['id' => recupIdfromUsername($_SESSION['username'])])) {
        $gamesSend = $stmt->fetchAll();
    } else {
        $error = "Erreur de connexion à la base de données.";
    }
    return $gamesSend;
}

function gamesReceive(){
    $connex = connexionBd();
    $sql = "SELECT * FROM games where player2_id = :id AND `status` = 'en attente'";
    $stmt = $connex->prepare($sql);

    if ($stmt->execute(['id' => recupIdfromUsername($_SESSION['username'])])) {
        $gamesReceive = $stmt->fetchAll();
    } else {
        $error = "Erreur de connexion à la base de données.";
    }
    return $gamesReceive;
}

function currentGames(){
    $connex = connexionBd();
    $sql = "SELECT * FROM games where (player2_id = :id OR player1_id = :id) AND `status` = 'en cours'";
    $stmt = $connex->prepare($sql);

    if ($stmt->execute(['id' => recupIdfromUsername($_SESSION['username'])])) {
        $games = $stmt->fetchAll();
    } else {
        $error = "Erreur de connexion à la base de données.";
    }
    return $games;
}

function alreadyPlayed($p1,$p2){

    $connex = connexionBd();
    $sql = "SELECT * FROM games where (player2_id = :id OR player1_id = :id) AND `status` = 'en cours'";
    $stmt = $connex->prepare($sql);

    if ($stmt->execute(['id' => recupIdfromUsername($_SESSION['username'])])) {
        $games = $stmt->fetchAll();
    } else {
        $error = "Erreur de connexion à la base de données.";
    }

}


function player1or2($gameId, $playerId){
    $connex = connexionBd();
    $sql = "SELECT player1_id, player2_id FROM games WHERE id = :gameId";
    $stmt = $connex->prepare($sql);

    if ($stmt->execute(['gameId' => $gameId])) {
        $gameInfo = $stmt->fetch();
        if ($gameInfo['player1_id'] == $playerId) {
            return 'player1_score';
        } elseif ($gameInfo['player2_id'] == $playerId) {
            return 'player2_score';
        } else {
            // Le joueur n'est ni le joueur 1 ni le joueur 2
            return null;
        }
    } else {
        // En cas d'échec de l'exécution de la requête
        return null;
    }

}


function player1or2adv($gameId, $playerId){
    $connex = connexionBd();
    $sql = "SELECT player1_id, player2_id FROM games WHERE id = :gameId";
    $stmt = $connex->prepare($sql);

    if ($stmt->execute(['gameId' => $gameId])) {
        $gameInfo = $stmt->fetch();
        if ($gameInfo['player1_id'] == $playerId) {
            return 'player2_score';
        } elseif ($gameInfo['player2_id'] == $playerId) {
            return 'player1_score';
        } else {
            // Le joueur n'est ni le joueur 1 ni le joueur 2
            return null;
        }
    } else {
        // En cas d'échec de l'exécution de la requête
        return null;
    }

}