<?php 

session_destroy();

// Rediriger l'utilisateur vers la page d'accueil
header('Location: ../');
exit();