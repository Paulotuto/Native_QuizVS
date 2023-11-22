<?php
setlocale (LC_TIME, 'fr_FR.utf8','fra'); 

define("SERVEUR","localhost:3306");
define("USER","ptallon");
define("MDP","dIsM0PzI");
define("BD","ptallon"); // c'est également votre login


/*
define("SERVEUR","sql304.infinityfree.com");
define("USER","if0_34913735");
define("MDP","YjVbT2HMllI3");
define("BD","if0_34913735_quizvs"); // c'est également votre login
*/


function connexionBd($hote=SERVEUR,$username=USER,$mdp=MDP,$bd=BD) {
   try {
       $connex= new PDO('mysql:host='.$hote.';dbname='.$bd, $username, $mdp);
       $connex->exec("SET CHARACTER SET utf8");	//Gestion des accents       
       return $connex;
   } catch(Exception $e) {
       echo 'Erreur : '.$e->getMessage().'<br>';
       echo 'N° : '.$e->getCode();
       return null;
   }
}