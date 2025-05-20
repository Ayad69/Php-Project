<?php

require_once('admin/model/UtilisateurDAO.php');
require_once('admin/model/AuthManager.php');
require_once('admin/model/LoueurDAO.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$authManager = new AuthManager();
$UtilisateurDAO = new UtilisateurDAO();


$module = "connexion";
$message_erreur = '';


if(isset($_GET['inscription'])){
    $module = "inscription";
}


if(isset($_POST['btnConnect'])) {

    if(isset($_POST['nom']) && $_POST['nom'] != '' &&
       isset($_POST['mot_de_passe']) && $_POST['mot_de_passe'] != '') {
        
        $message_erreur = $authManager->connecteUtilisateur($_POST['nom'], $_POST['mot_de_passe']);
        
        if($message_erreur == '') {
            header('Location: admin/view/stat/stat.php');
            exit;
        }
    } else {
        $message_erreur = 'Veuillez remplir tous les champs';
    }
}


if(isset($_POST['btnSignup'])) {
  
    if(isset($_POST['nom']) && $_POST['nom'] != '' &&
       isset($_POST['mot_de_passe']) && $_POST['mot_de_passe'] != '') {
        

        $utilisateur = $UtilisateurDAO->getByNom($_POST['nom']);
        
        if ($utilisateur) {
            $message_erreur = 'Cet identifiant est déjà utilisé';
        } else {
     
            $utilisateurDAO->ajouteUtilisateur($_POST['nom'], $_POST['mot_de_passe']);
            
     
            $authManager->connecteUtilisateur($_POST['nom'], $_POST['mot_de_passe']);
            
  
            header('Location: view/statistique.php');
            exit;
        }
    } else {
        $message_erreur = 'Il faut remplir les champs!';
    }
}


if($module == "inscription") {
    include('admin/view/inscription.php'); 
} elseif ($module == "connexion") {
    include('admin/view/connexion.php'); 
}