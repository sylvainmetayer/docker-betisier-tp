<?php
class Salarie extends Personne {
  private $per_num;
  private $sal_telprof;
  private $fon_num;


  public function __construct($valeurs = array()) {
    if (! empty ( $valeurs )) {
      parent::affecte($valeurs);
      $this->affecte ( $valeurs );
    }
  }

  public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'sal_telprof' :
          $this->setSalTelprof ( $valeurs );
					break;
				case 'fon_num' :
					$this->setFonNum ( $valeurs );
					break;
			}
		}
	}

  public function getPerNum(){
		return $this->per_num;
	}

	public function setPerNum($perNum){
    if (!isCorrectEntier($perNum)) {
      throw new ExceptionPerso("Le numero du libelle doit etre numerique", ExceptionPerso::ERR_NUMERIC);
    }
		$this->per_num = $perNum;
	}

	public function getSalTelprof(){
		return $this->sal_telprof;
	}

	public function setSalTelprof($salTelprof){
    if (!isCorrectNumeroDeTelephone($salTelprof)) {
      throw new ExceptionPerso("Le numero de téléphone doit etre sur 10 chiffres", ExceptionPerso::ERR_TEL);
    }
    $this->sal_telprof = $salTelprof;
	}

	public function getFonNum(){
		return $this->fon_num;
	}

	public function setFonNum($fonNum){
    if (!isCorrectEntier($fonNum)) {
      throw new ExceptionPerso("Le numéro de la fonction doit etre numerique", ExceptionPerso::ERR_NUMERIC);
    }
    $this->fon_num = $fonNum;
	}
}
