<?php

class Utilisateur {

	private int $id_utilisateur;
	private string $nom;	
	private string $mot_de_passe;	
	private string $rolee;

	public function __construct(int $i, string $n, string $mdp, string $r)
	{
		$this->id_utilisateur = $i;
		$this->nom = $n;
		$this->mot_de_passe = $mdp;
		$this->rolee = $r;
	}

	public function getIdentification() {
		return $this->id_utilisateur;
	}

	public function getNom() {
		return $this->nom;
	}

	public function getMotdepasse() {
		return $this->mot_de_passe;
	}

	public function getRolee() {
		return $this->rolee;
	}
		
	public function __set($attr, $value) {
		switch($attr) {
			case '$id_utilisateur':
				$this->id_utilisateur = $value;
				break;
			case 'nom':
				$this->nom = $value;
				break;
			case 'mot_de_passe':
				$this->mot_de_passe = $value;
				break;
			case 'rolee':
				$this->rolee = $value;
				break;
			default:
				echo 'ERROR';
				break;
		}
	}

}