<?php
class Departement {
	private $dep_num;
	private $dep_nom;
  private $vil_num;

	public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
	}

	public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'dep_num' :
          $this->setDepNum ( $valeurs );
					break;
				case 'dep_nom' :
					$this->setDepNom ( $valeurs );
					break;
        case 'vil_num':
          $this->setVilNum($valeurs);
          break;
			}
		}
	}

  public function setDepNum($dep_num) {
		if (!isCorrectEntier($dep_num)) {
			throw new ExceptionPerso("Erreur, le num&eacute; de d&eacute;partement doit &ecirc;tre une valeur num&eacute;rique.", ExceptionPerso::ERR_NUMERIC);
		}
    $this->dep_num = $dep_num;
  }

  public function getDepNum() {
    return $this->dep_num;
  }

  public function setDepNom($dep_nom) {
		if (empty($dep_nom)) {
			throw new ExceptionPerso("Un nom de département ne peut-être vide !", ExceptionPerso::ERR_CRITIQUE);

		}
		$this->dep_nom = $dep_nom;
  }

  public function getDepNom() {
    return $this->dep_nom;
  }

  public function setVilNum($vil_num) {
		if (!isCorrectEntier($vil_num)) {
			throw new ExceptionPerso("Erreur, le num&eacute; de la ville doit &ecirc;tre une valeur num&eacute;rique.", ExceptionPerso::ERR_NUMERIC);
		}
    $this->vil_num = $vil_num;
  }

  public function getVilNum() {
    return $this->vil_num;
  }
}
