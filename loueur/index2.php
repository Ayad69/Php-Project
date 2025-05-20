<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


require_once('loueur/model/Loueur.php');
require_once('loueur/model/LoueurDAO.php');
require_once('loueur/model/AuthManager.php');


try {
   
    $host = 'localhost';
    $dbname = 'php';
    $username = 'root';
    $password = '';
    
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
  
    $loueurDAO = new LoueurDAO($pdo);
    $authManager = new AuthManager($pdo); 
    
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}


$module = "connexion";
$message_erreur = '';

if(isset($_GET['inscription'])) {
    $module = "inscription";
}

if(isset($_POST['btnConnect'])) {
    if(isset($_POST['nom']) && $_POST['nom'] != '' &&
       isset($_POST['mot_de_passe']) && $_POST['mot_de_passe'] != '') {
        
        $message_erreur = $authManager->connecteLoueur($_POST['nom'], $_POST['mot_de_passe']);
        
        if($message_erreur == '') {
            header('Location: loueur/view/stat/stat.php');
            exit;
        }
    } else {
        $message_erreur = 'Veuillez remplir tous les champs';
    }
}

if(isset($_POST['btnSignup'])) {
    if(isset($_POST['nom']) && $_POST['nom'] != '' &&
       isset($_POST['mot_de_passe']) && $_POST['mot_de_passe'] != '') {
        
        $loueur = $loueurDAO->getByNom($_POST['nom']);
        
        if ($loueur) {
            $message_erreur = 'Cet identifiant de loueur est déjà utilisé';
        } else {
            $loueurDAO->ajouteLoueur($_POST['nom'], $_POST['mot_de_passe']);
            $authManager->connecteLoueur($_POST['nom'], $_POST['mot_de_passe']);
            
            header('Location: loueur/view/stat/stat.php');
            exit;
        }
    } else {
        $message_erreur = 'Il faut remplir les champs!';
    }
}


if($module == "inscription") {
    include('loueur/view/inscription.php'); 
} elseif ($module == "connexion") {
    include('loueur/view/connexion.php'); 
}
?>