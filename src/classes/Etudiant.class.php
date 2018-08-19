<?php
class Etudiant extends Personne {
  private $per_num;
  private $dep_num;
  private $div_num;

  public function __construct($valeurs = array()) {
    if (! empty ( $valeurs )) {
      parent::affecte($valeurs);
      $this->affecte ( $valeurs );
    }
  }

  public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'dep_num' :
          $this->setDepNum ( $valeurs );
					break;
				case 'div_num' :
					$this->setDivNum ( $valeurs );
					break;
			}
		}
	}

  public function getPerNum(){
		return $this->per_num;
	}

	public function setPerNum($perNum){
    if (!isCorrectEntier($perNum)) {
      throw new ExceptionPerso("Erreur, le num&eacute; de l'&eacute;tudiant doit &ecirc;tre une valeur num&eacute;rique.", ControleurSaisie::ERR_NUMERIC);
    }
		$this->per_num = $perNum;
	}

	public function getDepNum(){
		return $this->dep_num;
	}

	public function setDepNum($depNum){
    if (!isCorrectEntier($depNum)) {
      throw new ExceptionPerso("Erreur, le num&eacute; de d&eacute;partement doit &ecirc;tre une valeur num&eacute;rique.", ControleurSaisie::ERR_NUMERIC);
    }
		$this->dep_num = $depNum;
	}

	public function getDivNum(){
		return $this->div_num;
	}

	public function setDivNum($divNum){
    if (!isCorrectEntier($divNum)) {
      throw new ExceptionPerso("Erreur, le num&eacute; de la division doit &ecirc;tre une valeur num&eacute;rique.", ControleurSaisie::ERR_NUMERIC);
    }
		$this->div_num = $divNum;
	}

}
