<?php
class Vote {
  private $cit_num;
  private $per_num;
  private $vot_valeur;

  public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
  }

  public function affecte($donnees) {
    foreach ( $donnees as $attribut => $valeurs ) {
      switch ($attribut) {
        case 'cit_num' :
          if (!is_numeric($valeurs)) {
              throw new ExceptionPerso("Le numéro de la citation doit être numérique.", ExceptionPerso::ERR_NUMERIC);
          }
          $this->setCitNum ( $valeurs );
          break;
        case 'per_num' :
          $this->setPerNum ( $valeurs );
          break;
        case 'vot_valeur' :
          if (!is_numeric($valeurs)) {
              throw new ExceptionPerso("La valeur du vote doit être numérique.", ExceptionPerso::ERR_NUMERIC);
            }
            $this->setVoteValeur ( $valeurs );
            break;
      }
    }
  }

  public function setCitNum($valeur) {
    if (!isCorrectEntier($valeur)) {
      throw new ExceptionPerso("Merci de saisir le numero de la citation sous forme numérique !", ExceptionPerso::ERR_NUMERIC);
    }
    $this->cit_num = $valeur;
  }

  public function getCitNum() {
    return $this->cit_num;
  }

  public function setPerNum($valeur) {
    if (!isCorrectEntier($valeur)) {
      throw new ExceptionPerso("Merci de saisir le numero de la personne sous forme numérique !", ExceptionPerso::ERR_NUMERIC);
    }
    $this->per_num = $valeur;
  }

  public function getPerNum() {
    return $this->per_num;
  }

  public function setVoteValeur($valeur) {
    if (!isCorrectEntier($valeur)) {
      throw new ExceptionPerso("Merci de saisir la valeur de votre vote sous forme numérique !", ExceptionPerso::ERR_NUMERIC);
    }

    if(!isComprisEntre(0, 20, $valeur)) {
      throw new ExceptionPerso("Avez vous bien lu ? Une note doit être comprise entre 0 et 20 !", ExceptionPerso::ERR_PEBCAK);
    }

    $this->vot_valeur = $valeur;
  }

  public function getVotValeur() {
    return $this->vot_valeur;
  }

}
?>
