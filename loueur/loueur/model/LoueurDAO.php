<?php

class LoueurDAO {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    
    public function authentifier($nom, $mot_de_passe) {
       
        $stmt = $this->pdo->prepare("SELECT * FROM loueur WHERE nom = :nom");
        $stmt->execute(['nom' => $nom]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            
            if ($mot_de_passe == $result['mot_de_passe']) {
                return $this->createLoueurFromArray($result);
            }
        }

        return null;
    }

   
    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM loueur WHERE id = :id");
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            return $this->createLoueurFromArray($result);
        }

        return null;
    }

   
    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM loueur ORDER BY id");
        $loueurs = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $loueurs[] = $this->createLoueurFromArray($row);
        }

        return $loueurs;
    }

    public function add(Loueur $loueur) {
        $stmt = $this->pdo->prepare(
            "INSERT INTO loueur (nom, appels_ko, timeouts, date_analyse) 
             VALUES (:nom, :appels_ko, :timeouts, :date_analyse)"
        );

        return $stmt->execute([
            'nom' => $loueur->getNom(),
            'appels_ko' => $loueur->getAppelsKo(),
            'timeouts' => $loueur->getTimeouts(),
            'date_analyse' => $loueur->getDateAnalyse()
        ]);
    }

 
    public function update(Loueur $loueur) {
        $stmt = $this->pdo->prepare(
            "UPDATE loueur 
             SET nom = :nom, appels_ko = :appels_ko, timeouts = :timeouts, date_analyse = :date_analyse 
             WHERE id = :id"
        );

        return $stmt->execute([
            'id' => $loueur->getId(),
            'nom' => $loueur->getNom(),
            'appels_ko' => $loueur->getAppelsKo(),
            'timeouts' => $loueur->getTimeouts(),
            'date_analyse' => $loueur->getDateAnalyse()
        ]);
    }

    
    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM loueur WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

   
    private function createLoueurFromArray($data) {
        $loueur = new Loueur();
        $loueur->setId($data['id']);
        $loueur->setNom($data['nom']);
 
        if (isset($data['appels_ko'])) {
            $loueur->setAppelsKo($data['appels_ko']);
        }
        if (isset($data['timeouts'])) {
            $loueur->setTimeouts($data['timeouts']);
        }
        if (isset($data['date_analyse'])) {
            $loueur->setDateAnalyse($data['date_analyse']);
        }

        return $loueur;
    }
}