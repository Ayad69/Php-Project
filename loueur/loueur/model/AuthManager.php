<?php
require_once('LoueurDAO.php');

class AuthManager {
    private LoueurDAO $loueurDAO;

    public function __construct() {
        
        $dsn = 'mysql:host=localhost;dbname=php;charset=utf8';
        $username = 'root'; 
        $password = '';     

        try {
            $pdo = new PDO($dsn, $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->loueurDAO = new LoueurDAO($pdo);
        } catch (PDOException $e) {
            die('Erreur de connexion à la base de données : ' . $e->getMessage());
        }
    }

    public function connecteLoueur($nom, $mot_de_passe) {
        $loueur = $this->loueurDAO->authentifier($nom, $mot_de_passe);

        if ($loueur) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['id'] = $loueur->getId();
            $_SESSION['nom'] = $loueur->getNom();

            return '';
        } else {
            return 'Identifiant ou mot de passe incorrect';
        }
    }

    public function estConnecte() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['id']);
    }

    public function deconnecte() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = array();

        session_destroy();
    }
}