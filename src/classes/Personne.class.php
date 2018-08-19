<?php
class Personne {
  private $per_num;
  private $per_nom;
  private $per_prenom;
  private $per_tel;
  private $per_mail;
  private $per_admin;
  private $per_login;
  private $per_pwd;

  public function __construct($valeurs = array()) {
    if (! empty ( $valeurs )) {
      $this->affecte ( $valeurs );
    }
  }

  public function affecte($donnees) {
    foreach ( $donnees as $attribut => $valeurs ) {
      switch ($attribut) {
        case 'per_num' :
          $this->setPerNum ( $valeurs );
          break;
        case 'per_nom':
          $this->setPerNom($valeurs);
          break;
        case 'per_prenom':
          $this->setPerPrenom ( $valeurs );
          break;
        case 'per_tel':
          $this->setPerTel($valeurs);
          break;
        case 'per_mail':
          $this->setPerMail($valeurs);
          break;
        case 'per_admin':
          $this->setPerAdmin($valeurs);
          break;
        case 'per_login':
          $this->setPerLogin($valeurs);
          break;
        case 'per_pwd':
          $this->setPerPwd($valeurs);
          break;
      }
    }
  }

  public function getPerNum(){
		return $this->per_num;
	}

	public function setPerNum($perNum){
    if (!isCorrectEntier($perNum)) {
      throw new ExceptionPerso("Le num&eacute;ro de la personne doit &ecirc;tre num&eacute;rique.", ExceptionPerso::ERR_NUMERIC);
    }
		$this->per_num = $perNum;
	}

	public function getPerNom(){
		return $this->per_nom;
	}

	public function setPerNom($perNom){
    $nom = removeJavascript($perNom);
    if (empty($nom)) {
      throw new ExceptionPerso("Exception contrôlée, merci de ne pas saisir de javascript !", ExceptionPerso::ERR_PERSONNE);
    }

		$this->per_nom = $nom;
	}

	public function getPerPrenom(){
		return $this->per_prenom;
	}

	public function setPerPrenom($perPrenom){
    $prenom = removeJavascript($perPrenom);
    if (empty($prenom)) {
      throw new ExceptionPerso("Exception contrôlée, merci de ne pas saisir de javascript !", ExceptionPerso::ERR_PERSONNE);
    }
    $this->per_prenom = $prenom;
	}

	public function getPerTel(){
		return $this->per_tel;
	}

	public function setPerTel($perTel){
    if (!isCorrectNumeroDeTelephone($perTel)) {
			throw new ExceptionPerso("Le num&eacute;ro de telephone doit contenir 10 chiffres.", ExceptionPerso::ERR_TEL);
		}
		$this->per_tel = $perTel;
	}

	public function getPerMail(){
		return $this->per_mail;
	}

	public function setPerMail($perMail){
    if (!isCorrectEmail($perMail)) {
      throw new ExceptionPerso("Merci de saisir un mail valide !", ExceptionPerso::ERR_PERSONNE);
    }
		$this->per_mail = $perMail;
	}

	public function getPerLogin(){
		return $this->per_login;
	}

	public function setPerLogin($perLogin){
    if (empty($perLogin)) {
      throw new ExceptionPerso("Le login ne peut etre vide !", ExceptionPerso::ERR_PERSONNE);

    }
		$this->per_login = $perLogin;
	}

	public function getPerPwd(){
		return $this->per_pwd;
	}

	public function setPerPwd($perPwd){
    //Controle fait dans l'add et l'update de PersonneManager
		$this->per_pwd = $perPwd;
	}

  public function isPerAdmin(){
    return $this->per_admin;
  }

  public function setPerAdmin($perAdmin){
    $this->per_admin = $perAdmin;
  }
}
?>
