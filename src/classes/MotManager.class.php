<?php
class MotManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  /*
  Retourne un tableau de mots interdits, non accentues. utile pour l'ajout de citations
  */
  public function getAllMots() {
    $listeMots = array();

    $sql = "SELECT mot_id, mot_interdit FROM mot";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($mot = $requete->fetch(PDO::FETCH_OBJ)) {
      $motTmp = new Mot($mot);
      $motTmp = clean_chaine($motTmp->getMotInterdit());
      $motTmp = strtolower($motTmp);
      $listeMots[] = $motTmp;
    }
    return $listeMots;
  }

  /*Retourne un mot via son id*/
  public function getMotById($id) {
    $sql = "SELECT mot_id, mot_interdit FROM mot WHERE mot_id=:id";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":id", $id);
    $requete->execute();

    $mot = $requete->fetch(PDO::FETCH_OBJ);
    $motTmp = new Mot($mot);

    return $motTmp;
  }

  /*Retourne tous les mots*/
  public function getAllMotsObjets() {
    $listeMots = array();

    $sql = "SELECT mot_id, mot_interdit FROM mot ORDER BY mot_id ASC";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($mot = $requete->fetch(PDO::FETCH_OBJ)) {
      $motTmp = new Mot($mot);
      $listeMots[] = $motTmp;
    }

    return $listeMots;
  }

  /*Permet de mettre un jour un mot via son id*/
  public function update($mot) {
    if ($this->isMotExistant($mot->getMotInterdit())) {
      throw new ExceptionPerso("Ce mot est déjà interdit !", ExceptionPerso::ERR_MOT);
    }

    if (strlen($mot->getMotInterdit()) <= 3 ) {
      throw new ExceptionPerso("Un mot interdit doit est composé d'au moins 3 lettres !", 1);
    }

    $sql = "UPDATE mot SET mot_interdit=:mot WHERE mot_id=:id";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":id", $mot->getMotId());
    $requete->bindValue(":mot", $mot->getMotInterdit());

    $retour = $requete->execute();
    return $retour;
  }

  /*Permet de savoir si un mot est existant dans la  table*/
  public function isMotExistant($mot) {

    $sql = "SELECT mot_id, mot_interdit FROM mot WHERE MATCH(mot_interdit) AGAINST(:mot_interdit)";
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ":mot_interdit", $mot );

		$requete->execute();

		$resultat = $requete->fetch ( PDO::FETCH_OBJ );
		if ($resultat != null)
    {
			return new Mot ( $resultat );
		} else {
			return null;
		}
  }

  /*Permet d'ajouter un mot*/
  public function add($mot) {
    $sql = "INSERT INTO mot (mot_interdit) VALUES (:mot)";

    $isMotExistant = $this->isMotExistant($mot->getMotInterdit());
    if (!empty($isMotExistant)) {
      throw new ExceptionPerso("Ce mot est déjà interdit !", ExceptionPerso::ERR_MOT);
    }

    if (strlen($mot->getMotInterdit()) <= 3 ) {
      throw new ExceptionPerso("Un mot interdit doit est composé d'au moins 3 lettres !", 1);
    }

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":mot", $mot->getMotInterdit());

    $retour = $requete->execute();
    return $retour;
  }

  /*Permet de supprimer un mot par son id*/
  public function deleteById($id) {
    $sql = "DELETE FROM mot WHERE mot_id=:id";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":id", $id);

    $retour = $requete->execute();
    return $retour;
  }


}
