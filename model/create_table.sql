CREATE TABLE utilisateur (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    prenom VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    mot_de_passe VARCHAR(255) NOT NULL,
    pays VARCHAR(100),
    role ENUM('loueur', 'administrateur') NOT NULL DEFAULT 'loueur',
    telephone VARCHAR(20),
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    date_modification DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE stat (
    id_stat INT AUTO_INCREMENT PRIMARY KEY,
    id_utilisateur INT NOT NULL,
    date_collecte DATE NOT NULL,
    nb_retour_ko INT NOT NULL DEFAULT 0,
    nb_retour_ok INT NOT NULL DEFAULT 0,
    nb_total_retour INT NOT NULL DEFAULT 0,
    commentaire TEXT,
    date_creation DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_utilisateur) REFERENCES utilisateur(id_utilisateur) ON DELETE CASCADE,
    UNIQUE KEY unique_stat (id_utilisateur, date_collecte)
);