<?php
session_start();




/*
 * Initialise la connexion à la base de données et renvoie l'objet PDO
 */
function initialiseConnexionBDD() {
	$bdd = null;
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=projet;charset=utf8', 
			'root', 
			''
		);	
	} catch(Exception $e) {
		die('Erreur connexion BDD : '.$e->getMessage());
	}

	return $bdd;
}

/*
 * Vérifie les informations données par l'utilisateur et le connecte ou non
 */
function connecteUtilisateur($email, $motdepasse) {
	$res = '';
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$sql = 'SELECT * FROM utilisateur 
		WHERE email ="'.$email.'" AND mot_de_passe = "'.$motdepasse.'";';
		$result = $bdd->query($sql);
		/* DEBUG pour vérifier la requête
			var_dump($sql);
			var_dump($result->fetch());
			die();
		 */
			$data = $result->fetch();
if ($data) {
    $_SESSION['id_utilisateur'] = intval($data['id_utilisateur']);
    $_SESSION['utilisateur_email'] = $data['email'];
} else {
			$res = 'Utilisateur inconnu ou mot de passe erroné';
		}
	}
	return $res;	
}

/**
 * Ajoute un utilisateur à la base de données
 */
function ajouteUtilisateur($nom, $motdepasse) {
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$query = $bdd->prepare('INSERT INTO roulette_joueur (nom, motdepasse, argent) VALUES (:t_nom, :t_mdp, 500);');
		$query->execute(array('t_nom' => $nom, 't_mdp' => $motdepasse));
	}
}

