<?php

include '../function/gestionBD.inc.php';  

session_start();

if (isset($_POST['prenom'], $_POST['mdp'])) {
    $username = $_POST['prenom'];
    $mdp = $_POST['mdp'];

    $connex = connexionBd();

    if ($connex) {
        $sql = "SELECT mdp FROM utilisateurs WHERE username = :username";
        $stmt = $connex->prepare($sql);
        
        if ($stmt->execute(['username' => $username])) {
            $result = $stmt->fetch();
            
            if ($result && password_verify($mdp, $result['mdp'])) {
                // Les identifiants sont corrects
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                header('Location: ./accueil.php'); // Redirige vers la page d'accueil
                exit;
            } else {
                // Les identifiants sont incorrects
                $error = "Nom d'utilisateur ou mot de passe incorrect";
            }
        } else {
            $error = "Erreur lors de la vérification des identifiants.";
        }
    } else {
        $error = "Erreur de connexion à la base de données.";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>

<div class="formSignUp">
    <h2>Se connecter</h2>
    <?php if (isset($error)): ?>
        <p style="color: red;"><?= $error ?></p>
    <?php endif; ?>
    <form action="login.php" method="post">
        <label for="prenom">Identifiant</label>
        <br>
        <input type="text" id="prenom" name="prenom">
        <br>
        <label for="mdp">Mot de Passe</label>
        <br>
        <input type="password" id="mdp" name="mdp">
        <br>
        <input type="submit" value="Se connecter">
    </form>
</div>

</body>
</html>
