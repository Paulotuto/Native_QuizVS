<?php
include '../function/gestionBD.inc.php'; // Assurez-vous que votre fichier 'gestionBD.php' est dans le même dossier ou ajustez le chemin en conséquence


$message = '';

if (isset($_POST['prenom'], $_POST['mdp'], $_POST['mdpconf'])) {
    
    if ($_POST['mdp'] !== $_POST['mdpconf']) {
        // Les mots de passe ne correspondent pas
        header("Location: /");
        exit;
    }

    $username = $_POST['prenom'];
    $connex = connexionBd();

    if ($connex) {
        // Vérifier si le nom d'utilisateur existe déjà
        $checkUserSql = "SELECT COUNT(*) as nb FROM `utilisateurs` WHERE `username` = :username";
        $checkStmt = $connex->prepare($checkUserSql);
        $checkStmt->execute(['username' => $username]);
        $result = $checkStmt->fetch();

        if ($result['nb'] != 0) {
            // Le nom d'utilisateur existe déjà
            $message='Un utilisateur utilise déjà ce nom';
        } else {
            // Inscrire le nouvel utilisateur
        $mdp = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
        $sql = "INSERT INTO `utilisateurs`(`username`, `mdp`) VALUES (:username, :mdp)";
        $stmt = $connex->prepare($sql);

        if ($stmt->execute(['username' => $username, 'mdp' => $mdp])) {
            header("Location: login.php");
            exit;
        } else {
            header("Location: index.html");
            exit;
        }

        }

        
    } 
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/reset.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>

<body>
    <div class="formSignUp">
        <h2>S'inscrire</h2>
        <form action="./signup.php" method="post">
            <p><?=$message?></p>
            <label for="prenom">Identifiant :</label>

            
            <input type="text" id="prenom" name="prenom" required>

            <label for="mdp">Mot de Passe:</label>

            <input type="password" id="mdp" name="mdp" required>
            
            <label for="mdpconf">Confirmez votre Mot de passe :</label>

            <input type="password" id="mdpconf" name="mdpconf" required>
            <input type="submit" value="S'inscrire">
        </form>
    </div>
</body>

</html>