<?php
class Pwd {
	private $pwd_libelle;
	private $pwd_num;

	public function __construct($valeurs = array()) {
		if (! empty ( $valeurs )) {
			$this->affecte ( $valeurs );
		}
	}

	public function affecte($donnees) {
		foreach ( $donnees as $attribut => $valeurs ) {
			switch ($attribut) {
				case 'pwd_libelle' :
					$this->setPwdInterdit ( $valeurs );
					break;
				case 'pwd_num':
					$this->setPwdNum($valeur);
					break;
			}
		}
	}

	public function getPwdNum() {
		return $this->pwd_num;
	}

	public function setPwdNum($pwd_num) {
		$this->pwd_num = $pwd_num;
	}

  public function getPwdInterdit() {
    return $this->pwd_libelle;
  }

  public function setPwdInterdit($pwd_libelle) {
    $this->pwd_libelle = $pwd_libelle;
  }
}
