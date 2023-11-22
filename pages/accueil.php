<?php
session_start();

include_once '../function/gestionBD.inc.php';

include '../function/functions.php';

$players = [];
$games = [];

$connex = connexionBd();

if ($connex) {

    $players = allPlayersEvenMe();

    $gamesSend = gamesSend();

    $gamesReceive = gamesReceive();

    $games = currentGames();

}



?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <title>Accueil</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/styles.css">

</head>

<body class='homePlayer'>
    <div class='gauche'>
        <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
            <h2>Bienvenue,
                <?= $_SESSION['username'] ?> !
            </h2>
            <ul class="gamesSend cacher">


                <?php foreach ($gamesSend as $game): ?>
                    <li>
                        Invitation envoyée à
                        <?= recupUsernamefromId($game['player2_id']); ?>
                    </li>

                <?php endforeach; ?>
            </ul>
            <ul class="games">

                <?php if (count($games) == 0): ?>
                    <li>
                        Pas de parties en cours pour le moment...<br>essayez d'aller voir vos invitations <br> ou invitez vos
                        amis !</a>
                    </li>

                <?php endif; ?>
                <?php foreach ($games as $game): ?>
                    <section class="card">
                        <li>
                            <article class="player1">
                                <span>
                                    <?= recupUsernamefromId($game['player2_id']); ?>
                                </span>
                                <span>
                                    <?= $game['player2_score'] ?>
                                </span>
                            </article>
                            <span class="vs">VS</span>


                            <?php if ($game['player1_score'] == 0 && $game['player2_score'] == 0): ?>
                                <!-- Aucun joueur n'a encore joué -->
                                <form method="post" action="game.php?gameID=<?= $game['id']; ?>">
                                    <input type="hidden" name="player1" value="<?= recupUsernamefromId($game['player1_id']); ?>">
                                    <input type="hidden" name="player2" value="<?= recupUsernamefromId($game['player2_id']); ?>">
                                    <button type="submit" class="btnInvit">Jouer</button>
                                </form>
                            <?php else: ?>
                                <!-- Au moins un joueur a joué -->
                                <?php if ($game[player1or2($game['id'], recupIdfromUsername($_SESSION['username']))] == 0): ?>
                                    <form method="post" action="game.php?gameID=<?= $game['id']; ?>">
                                        <input type="hidden" name="player" value="player1">
                                        <button type="submit" class="btnInvit">Jouer</button>
                                    </form>
                                <?php else: ?>
                                    <?php if ($game[player1or2adv($game['id'], recupIdfromUsername($_SESSION['username']))] == 0): ?>
                                        <p class="vs">En attente</p>
                                    <?php else: ?>
                                        <form method="post" action="../function/close_game.php">
                                            <input type="hidden" name="game_id" value="<?=$game['id']?>">
                                            <button type="submit" class="btnInvit">Fermer</button>
                                        </form>
                                    <?php endif; ?>
                                <?php endif; ?>


                            <?php endif; ?>



                            <article class="player2">
                                <span>
                                    <?= recupUsernamefromId($game['player1_id']); ?>
                                </span>
                                <span>
                                    <?= $game['player1_score'] ?>
                                </span>
                            </article>
                        </li>
                    </section>


                <?php endforeach; ?>
            </ul>
            <ul class="gamesReceive cacher">

                <?php if (count($gamesReceive) == 0): ?>
                    <li>
                        Pas d'invitations pour le moment...<br>essayez de <a href="accueil.php">rafraichir</a>
                    </li>

                <?php endif; ?>
                <?php foreach ($gamesReceive as $game): ?>
                    <li>
                        <?= recupUsernamefromId($game['player1_id']); ?> vous a invité <a
                            href="<?= acceptgame($game['id']) ?>">Accept</a>
                    </li>

                <?php endforeach; ?>
            </ul>
            <section class="btngames">
                <p class="recues">Invitations recues (<?= count($gamesReceive) ?>)
                </p>
                <p class="encours">Parties en cours</p>
                <p class="envoyees">Invitations envoyées (<?= count($gamesSend) ?>)
                </p>
            </section>

            <a href="../function/logout.php">Se déconnecter</a>
        <?php else: ?>
            <p>Vous n'êtes pas connecté. <a href="login.php">Se connecter</a></p>
        <?php endif; ?>
    </div>

    <div class="droite">
        <hr>
        <ul>


            <?php foreach ($players as $player): ?>
                <li>
                    <?= $player['username']; ?>
                    <form method="post" action="../function/create_game.php">
                        <input type="hidden" name="player1" value="<?= $_SESSION['username']; ?>">
                        <input type="hidden" name="player2" value="<?= $player['username']; ?>">
                        <button type="submit" class="btnInvit">Inviter</button>
                    </form>
                </li>
            <?php endforeach; ?>

        </ul>
        <hr>
    </div>
    <script>
        const username = "<?php echo $_SESSION['username']; ?>";
    </script>
    <script defer src="../script/invitation.js"></script>
</body>


</html>