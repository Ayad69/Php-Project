<?php
session_start();

/*
 * Initialise la connexion à la base de données et renvoie l'objet PDO
 */
function initialiseConnexionBDD() {
	$bdd = null;
	try {
		$bdd = new PDO('mysql:host=localhost;dbname=roulette_cybersecu;charset=utf8', 
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
function connecteUtilisateur($utilisateur, $motdepasse) {
	$res = '';
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$sql = 'SELECT * FROM roulette_joueur 
		WHERE nom ="'.$utilisateur.'" AND motdepasse = "'.$motdepasse.'";';
		$result = $bdd->query($sql);
		/* DEBUG pour vérifier la requête
			var_dump($sql);
			var_dump($result->fetch());
			die();
		 */
			$data = $result->fetch();
		if($data) {
			$_SESSION['joueur_id'] = intval($data['identifiant']);
			$_SESSION['joueur_nom'] = $data['nom'];
			$_SESSION['joueur_argent'] = intval($data['argent']);
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

/**
 * Ajoute une partie jouée à la base de données
 */
function ajoutePartie($id_joueur, $date, $mise, $gain) {
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$query = $bdd->prepare('INSERT INTO roulette_partie (joueur, date, mise, gain) VALUES ( :t_id, :t_date, :t_mise, :t_gain);');
		$query->execute(array('t_id' => $id_joueur, 't_date' => $date, 't_mise' => $mise, 't_gain' => $gain));
	}
}


/**
 * Met à jour l'argent détenu par un joueur dans la base de données
 */
function majUtilisateur($id_joueur, $argent) {
	$bdd = initialiseConnexionBDD();
	if($bdd) {
		$query = $bdd->prepare('UPDATE roulette_joueur SET argent = :t_argent WHERE identifiant = :t_id;');
		$query->execute(array('t_argent' => $argent, 't_id' => $id_joueur));
	}
}