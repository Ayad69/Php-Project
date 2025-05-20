<?php
require_once('UtilisateurDAO.php');



class AuthManager {
    private UtilisateurDAO $utilisateurDAO;
    
    public function __construct() {
        $this->utilisateurDAO = new UtilisateurDAO();
    }
    
   
    public function connecteUtilisateur($nom, $mot_de_passe) {
        $utilisateur = $this->utilisateurDAO->authentifier($nom, $mot_de_passe);
        
        if ($utilisateur) {
         
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
            
        
            $_SESSION['id_utilisateur'] = $utilisateur->getIdentification();
            $_SESSION['nom'] = $utilisateur->getNom();
            
            return '';
        } else {
            return 'Identifiant ou mot de passe incorrect';
        }
    }
    
   
    public function estConnecte() {
    
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['id_utilisateur']);
    }
    
    
    public function deconnecte() {
     
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
       
        $_SESSION = array();
        
       
        session_destroy();
    }
    
  
}