<?php
require_once('Utilisateur.php');
require_once('config/Database.php');
require_once('DAO.php');

class UtilisateurDAO implements DAO {
    private PDO $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
  
    public function getAll() {
        $utilisateurs = [];
        $stmt = $this->db->query('SELECT * FROM utilisateur ORDER BY nom DESC');
        
        while ($data = $stmt->fetch()) {
            $utilisateurs[] = new Utilisateur(
                $data['id_utilisateur'], 
                $data['nom'], 
                $data['mot_de_passe'], 
                $data['rolee']
            );
        }
        
        return $utilisateurs;
    }
    
 
    public function getById($id) {
        $stmt = $this->db->prepare('SELECT * FROM utilisateur WHERE id_utilisateur = :id');
        $stmt->execute(['id' => $id]);
        $data = $stmt->fetch();
        
        if ($data) {
            return new Utilisateur(
                $data['id_utilisateur'], 
                $data['nom'], 
                $data['mot_de_passe'], 
                $data['rolee']
            );
        }
        
        return null;
    }
    
   
    public function getByNom($nom) {
        $stmt = $this->db->prepare('SELECT * FROM utilisateur WHERE nom = :nom');
        $stmt->execute(['nom' => $nom]);
        $data = $stmt->fetch();
        
        if ($data) {
            return new Utilisateur(
                $data['id_utilisateur'], 
                $data['nom'], 
                $data['mot_de_passe'], 
                $data['rolee']
            );
        }
        
        return null;
    }
    
  
    public function add($utilisateur) {
        $stmt = $this->db->prepare(
            'INSERT INTO utilisateur (nom, mot_de_passe, rolee) 
             VALUES (:nom, :motdepasse, :rolee)'
        );
        
        return $stmt->execute([
            'nom' => $utilisateur->getNom(),
            'mot_de_passe' => $utilisateur->getMotdepasse()
         
        ]);
    }
    

    public function ajouteUtilisateur($nom, $mot_de_passe) {
        $stmt = $this->db->prepare(
            'INSERT INTO utilisateur (nom, mot_de_passe, rolee)                 
             VALUES (:nom, :mot_de_passe, :rolee)'
        );
        
        return $stmt->execute([
            'nom' => $nom,
            'mot_de_passe' => $mot_de_passe
        ]);
    }
    
  
    public function update($utilisateur) {
        $stmt = $this->db->prepare(
            'UPDATE utilisateur
             SET nom = :nom, mot_de_passe = :mot_de_passe 
             WHERE id_utilisateur = :id'
        );
        
        return $stmt->execute([
            'id_utilisateur' => $utilisateur->getIdentification(),
            'nom' => $utilisateur->getNom(),
            'mot_de_passe' => $utilisateur->getMotdepasse(),
            'rolee' => $utilisateur->getRolee()
        ]);
    }
    
  
    
    
    
   
    public function delete($id) {
        $stmt = $this->db->prepare('DELETE FROM utilisateur WHERE id_utilisateur = :id');
        return $stmt->execute(['id_utilisateur' => $id]);
    }
    
    
    public function authentifier($nom, $mot_de_passe) {
        $stmt = $this->db->prepare(
            'SELECT * FROM utilisateur 
             WHERE nom = :nom AND mot_de_passe = :mot_de_passe'
        );
        
        $stmt->execute([
            'nom' => $nom,
            'mot_de_passe' => $mot_de_passe
        ]);
        
        $data = $stmt->fetch();
        
        if ($data) {
            return new  Utilisateur(
                $data['id_utilisateur'], 
                $data['nom'], 
                $data['mot_de_passe'], 
                $data['rolee']
            );
        }
        
        return null;
    }

}