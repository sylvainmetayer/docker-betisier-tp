<?php
class PersonneManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  /*
  Cette fonction permet d'ajouter une personne dans la base de données, en effecuant divers tests avant.
  */
  public function add($personne) {

    if ( !isPwdStrongEnough($personne->getPerPwd()) ) {
      throw new ExceptionPerso("Le mot de passe doit faire au moins 6 caractères, et ne pas être trop simple, merci de le changer !", ExceptionPerso::ERR_PERSONNE);
    }

    $isLoginAvailable = $this->isLoginAvailable($personne->getPerLogin());
    if (!empty($isLoginAvailable)) {
      throw new ExceptionPerso("Le login demand&eacute; est d&eacute;j&agrave; pris, d&eacute;sol&eacute; !", ExceptionPerso::ERR_PERSONNE);
    }

    $sql = "INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_admin, per_login, per_pwd) VALUES (:nom, :prenom, :tel, :mail, :admin, :login, :pwd)";

    $requete = $this->db->prepare($sql);

    $requete->bindValue(":nom", $personne->getPerNom());
    $requete->bindValue(":prenom", $personne->getPerPrenom());
    $requete->bindValue(":tel", $personne->getPerTel());
    $requete->bindValue(":mail", $personne->getPerMail());
    $requete->bindValue(":admin", 0);
    $requete->bindValue(":login", $personne->getPerLogin());
    $requete->bindValue(":pwd", (md5(md5($personne->getPerPwd()).GRAIN_SEL)));

    $retour = $requete->execute();
    return $retour;
  }

  /*Permet de mettre a jour le mot de passe d'une personne
  ancienPwd = pwd passé en clair, qui est l'ancien mdp a etre soumis a verification avant l'update
  */
  public function updatePwd($per_num, $ancienPwd, $pwdEnClair) {

    /*On ne se sert pas de quitterModifierPersonne lors d'un simple changment de mot de passe (changerPwd.inc.php),
    mais etant donné que la fonction ne fait rien dans ce cas, il est inutile de supprimer ce code,
    etant donné qu'il est nécessaire pour modifierPersonne. */

    $personne = $this->getPersonne($per_num);

    $connexionAutorise = $this->isConnexionAutorisee($personne->getPerLogin(), $ancienPwd);
    if (!$connexionAutorise) {
      quitterModifierPersonne();
      throw new ExceptionPerso("Mot de passe incorrect, impossible de mettre à jour votre mot de passe !", ExceptionPerso::ERR_PERSONNE);
    }

    if ( !isPwdStrongEnough($pwdEnClair) ) {
      quitterModifierPersonne();
      throw new ExceptionPerso("Merci de choisir un mot de passe plus complexe (composé de plus de 6 caractères, et difficile à deviner) ", ExceptionPerso::ERR_PERSONNE);
    }

    $sql = "UPDATE personne SET per_pwd =:per_pwd WHERE per_num=:per_num";

    $pwdCrypte = md5(md5($pwdEnClair).GRAIN_SEL);

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_pwd", $pwdCrypte);
    $requete->bindValue(":per_num", $per_num);

    $retour = $requete->execute();
    return $retour;
  }

  /*Permet de mettre à jour les détails d'une personne*/
  public function update($personne) {

    $sql =  "UPDATE personne SET
            per_nom=:per_nom,
            per_prenom=:per_prenom ,
            per_tel=:per_tel,
            per_mail=:per_mail,
            per_login=:per_login WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);

    $requete->bindValue(":per_nom", $personne->getPerNom());
    $requete->bindValue(":per_prenom", $personne->getPerPrenom());
    $requete->bindValue(":per_tel", $personne->getPerTel());
    $requete->bindValue(":per_mail", $personne->getPerMail());
    $requete->bindValue(":per_login", $personne->getPerLogin());
    $requete->bindValue(":per_num", $personne->getPerNum());

    $retour = $requete->execute();
    return $retour;
  }

  /*Permet de supprimer toutes référence à une personne et la supprime*/
  public function deleteByPerNum($per_num) {
    $voteManager = new VoteManager($this->db);
    $citationManager = new CitationManager($this->db);
    $personneManager = new PersonneManager($this->db);

    $listeVoteDeLaPersonne = $voteManager->getVoteByPerNum($per_num);

    if ($personneManager->isEtudiant($per_num)) {
      $listeCitationDeLaPersonne = $citationManager->getCitationToDeleteForStudent($per_num);
      if (isset($listeCitationDeLaPersonne)) {
        foreach ($listeCitationDeLaPersonne as $citation) {
          $voteManager->deleteVoteByCitNum($citation->getCitationNum());
          $citationManager->deleteCitationByCitNum($citation->getCitationNum());
        }
      }
    } else {
      $listeCitationDeLaPersonne = $citationManager->getCitationToDeleteForProf($per_num);
      if (isset($listeCitationDeLaPersonne)) {
        foreach ($listeCitationDeLaPersonne as $citation) {
          $voteManager->deleteVoteByCitNum($citation->getCitationNum());
          $citationManager->deleteCitationByCitNum($citation->getCitationNum());
        }
      }
    }

    if (isset($listeVoteDeLaPersonne)) {
      foreach ($listeVoteDeLaPersonne as $vote) {
        $voteManager->deleteVoteByPerNum($vote->getPerNum());
      }
    }

    if (isset($listeCitationDeLaPersonne)) {
      foreach ($listeCitationDeLaPersonne as $citation) {
        $citationManager->deleteCitationByCitNum($citation->getCitationNum());
      }
    }


    if ($personneManager->isEtudiant($per_num)) {
      $etudiantManager = new EtudiantManager($this->db);
      $retour = $etudiantManager->delete($per_num);
    } else {
      $salarieManager = new SalarieManager($this->db);
      $retour = $salarieManager->delete($per_num);
    }

    $sql="DELETE FROM personne WHERE per_num=:per_num;";
    $requete = $this->db->prepare($sql);
    $requete->bindValue(':per_num', $per_num);
    $retour = $requete->execute();

    return $retour;
	}

  /*
  Cette fonction permet de savoir si un login est déjà pris ou non.
  Retourne un objet personne ou NULL selon que le login est libre ou non.
  */
  public function isLoginAvailable($login) {
    $sql = "SELECT * FROM personne WHERE per_login=:per_login";
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ":per_login", $login );

		$requete->execute();

		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		if ($resultat != null) // Le login existe déjà
    {
			return new Personne ( $resultat );
		} else {
			return null;
		}
  }

  /*Permet de savoir si le numero d'une personne est déjà existant*/
  public function isPerNumExistant($per_num) {
    $sql = "SELECT per_num FROM personne WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue("per_num", $per_num);

    $requete->execute();

    $resultat = $requete->fetch(PDO::FETCH_ASSOC);

    if (empty($resultat)) {
      return false;
    }
    return true;

  }

  /*
  Cette fonction permet de savoir si un utilisateur a
  le droit de se connecter, en passant un mot de passe en clair, et un nom d'utilisateur.
  Une vérification est alors effectuée en comparant les paramètres et ceux stocké en base (en cryptant le mot de passe).
  Retourne true ou false selon que la connexion est autorisée ou non.
  */
  public function isConnexionAutorisee($login, $pwd) {
    $sql = "SELECT per_login, per_pwd FROM personne WHERE per_pwd=:per_pwd AND per_login=:per_login";
    $requete = $this->db->prepare($sql);

    $pwdCrypte = md5(md5($pwd).GRAIN_SEL);
    $requete->bindValue(':per_login', $login);
    $requete->bindValue(':per_pwd', $pwdCrypte);

    $requete->execute();

    $resultat = $requete->fetch(PDO::FETCH_OBJ);
    $requete->closeCursor();
    if ($resultat != NULL) {
      return true;
    } else {
      return false;
    }
  }

  /*
  Cette fonction retourne une personne en fonction de son per_num.
  Retourne un objet Personne ou null si le numero n'identifie aucune personne.
  */
  public function getPersonne($per_num) {
    $sql = "SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_admin, per_login, per_pwd FROM personne WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);

    $requete->execute();

    $tmp = $requete->fetch(PDO::FETCH_OBJ);
    $tmp ? $personne = new Personne($tmp) : $personne = null;

    $requete->closeCursor();
    return $personne;
  }

  /*
  Cette fonction permet de récupérer les informations d'une personne en fonction de son login.
  Retourne un objet Personne ou null si la personne n'existe pas.
  */
  public function getPersonneByLogin($per_login) {
    $sql = "SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_admin, per_login, per_pwd FROM personne WHERE per_login=:per_login";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_login", $per_login);
    $requete->execute();

    $ligne = $requete->fetch(PDO::FETCH_OBJ);
    $personne = new Personne($ligne);
    $requete->closeCursor();
    return $personne;
  }

  /*
  Fonction qui permet de lister toutes les personnes présente dans la base de données.
  Retourne un tableau d'objet Personne
  */
  public function getAllPersonnes() {
    $listePersonnes = array();

    $sql = 'SELECT per_num, per_nom, per_prenom, per_tel, per_mail, per_admin, per_login, per_pwd FROM personne';

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($personne = $requete->fetch(PDO::FETCH_OBJ)) {
      $listePersonnes[] = new Personne($personne);
    }
    $requete->closeCursor();
    return $listePersonnes;
  }

  /*Permet de savoir si une personne est un étudiant*/
  public function isEtudiant($per_num) {
    $sql = "SELECT per_num FROM etudiant WHERE per_num=:per_num";

    $requete = $this->db->prepare ( $sql);
    $requete->bindValue(":per_num", $per_num);

		$retour = $requete->execute ();
		if ($ligne = $requete->fetch ( PDO::FETCH_ASSOC )) {
			$retour = true;
		} else {
			$retour = false;
		}

    $requete->closeCursor ();
		return $retour;
  }

}
?>
