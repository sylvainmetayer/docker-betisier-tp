<?php
class Division {
  private $div_num;
	private $div_nom;

	public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
	}

	public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'div_num' :
          $this->setDivNum ( $valeurs );
					break;
				case 'div_nom' :
					$this->setDivNom ( $valeurs );
					break;
			}
		}
	}

  public function setDivNum($div_num) {
		if (!isCorrectEntier($div_num)) {
			throw new ExceptionPerso("Erreur, le num&eacute; de la division doit &ecirc;tre une valeur num&eacute;rique.", ExceptionPerso::ERR_NUMERIC);
		}
    $this->div_num = $div_num;
  }

  public function getDivNum() {
    return $this->div_num;
  }

  public function setDivNom($div_nom) {
    if (empty($div_nom)) {
      throw new ExceptionPerso("Le nom de la division ne peut-être vide !", ExceptionPerso::ERR_CRITIQUE);
    }
    $this->div_nom = $div_nom;
  }

  public function getDivNom() {
    return $this->div_nom;
  }

}
?>
