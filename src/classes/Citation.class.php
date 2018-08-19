<?php
class Citation {
	private $cit_num;
	private $per_num;
	private $per_num_valide;
	private $per_num_etu;
	private $cit_libelle;
	private $cit_date;
	private $cit_valide;
	private $cit_date_valide;
	private $cit_date_depo;

	public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
	}

	public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'cit_num' :
					$this->setCitationNum ( $valeurs );
					break;
				case 'per_num' :
					$this->setCitationPerNum ( $valeurs );
					break;
				case 'per_num_valide':
					$this->setCitationPerNumValide ( $valeurs );
					break;
				case 'per_num_etu':
					$this->setCitationPerNumEtu ( $valeurs );
					break;
				case 'cit_libelle':
					$this->setCitationLibelle($valeurs);
					break;
				case 'cit_date':
					$this->setCitationDate($valeurs);
					break;
				case 'cit_valide':
					$this->setCitationValide($valeurs);
					break;
				case 'cit_date_valide':
					$this->setCitationDateValide($valeurs);
					break;
				case 'cit_date_depo':
					$this->setCitationDateDepot($valeurs);
					break;
			}
		}
	}

	public function setCitationDateValide($valeur) {
		if (!empty($valeur)) {
			if (!isCorrectDate($valeur)) {
				throw new ExceptionPerso("La date de validation de la citation ne peut &ecirc;tre nulle !", ExceptionPerso::ERR_DATE);
			}
		}
		$this->cit_date_valide = $valeur;
	}

	public function getCitationDateValide() {
		return $this->cit_date_valide;
	}

	public function setCitationNum($valeur) {
		if (!isCorrectEntier($valeur)) {
			throw new ExceptionPerso("Erreur, le numéro de la citation doit &ecirc;tre num&eacute;rique.  ", ExceptionPerso::ERR_NUMERIC);
		}
		$this->cit_num = $valeur;
	}

	public function getCitationNum() {
		return $this->cit_num;
	}

	public function setCitationDate($valeur) {
		if (!isCorrectDate($valeur)) {
			throw new ExceptionPerso("La date de dépot de la citation ne peut être dans le futur ! Il faut qu'elle ai été prononcée d'abord.", ExceptionPerso::ERR_DATE);
		}
		$this->cit_date = $valeur;
	}

	public function getCitationDate() {
		return $this->cit_date;
	}

	public function setCitationPerNum($valeur) {
		if (!isCorrectEntier($valeur)) {
			throw new ExceptionPerso("Erreur, le numéro du prof concerné par la blague doit &ecirc;tre num&eacute;rique.  ", ExceptionPerso::ERR_NUMERIC);
		}
		$this->per_num = $valeur;
	}

	public function getCitationPerNum() {
		return $this->per_num;
	}

	public function setCitationValide($valeur) {
		$this->cit_valide = $valeur;
	}

	public function getCitationValide() {
		return $this->cit_valide;
	}

	public function setCitationPerNumEtu($valeur) {
		if (!isCorrectEntier($valeur)) {
			throw new ExceptionPerso("Erreur, le numéro de l'&eacute,tudiant doit &ecirc;tre num&eacute;rique.", ExceptionPerso::ERR_NUMERIC);
		}
		$this->per_num_etu = $valeur;
	}

	public function getCitationPerNumEtu() {
		return $this->per_num_etu;
	}

	public function setCitationDateDepot($valeur) {
		$this->cit_date_depo = $valeur;
	}

	public function getCitationDateDepot() {
		return $this->cit_date_depo;
	}

	public function setCitationPerNumValide($valeur) {
		$this->per_num_valide = $valeur;
	}

	public function getCitationPerNumValide() {
		return $this->per_num_valide;
	}

	public function setCitationLibelle($valeur) {
		$libelle = removeJavascript($valeur);
		if (empty($libelle)) {
			throw new ExceptionPerso("Le contenu de la blague ne peut-être vide !", ExceptionPerso::ERR_CITATION);
		}

		$this->cit_libelle = $libelle;
	}

	public function getCitationLibelle() {
		return $this->cit_libelle;
	}
}
