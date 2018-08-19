<?php
class Ville {
	private $vil_num;
	private $vil_nom;

	public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
	}

	public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'vil_nom' :
          $this->setVilleNom ( $valeurs );
					break;
				case 'vil_num' :
					$this->setVilleNum ( $valeurs );
					break;
			}
		}
	}

  public function getVilleNom() {
    return $this->vil_nom;
  }

  public function setVilleNom($vil_nom) {
		$vil_nom = removeJavascript($vil_nom);
		if (empty($vil_nom)) {
			throw new ExceptionPerso("Le nom d'une ville ne peut être vide !", ExceptionPerso::ERR_VILLE);
		}
    $this->vil_nom = $vil_nom;
  }

  public function getVilleNum() {
    return $this->vil_num;
  }

  public function setVilleNum($vil_num) {
		if (!isCorrectEntier($vil_num)) {
			throw new ExceptionPerso("Le num&eacute;ro de la ville doit &ecirc;tre num&eacute;rique.", ExceptionPerso::ERR_NUMERIC);
		}
    $this->vil_num = $vil_num;
  }
}
  /* Fin Ville.class.php */
