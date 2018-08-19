<?php
class SalarieManager extends PersonneManager {

  public function __construct($db) {
    parent::__construct($db);
    $this->db = $db;
  }

  /*
  Cette fonction permet d'ajouter un salarie, en l'ajoutant d'abord dans la table personne.
  Si cette fonction retourne quelque chose différent de 0, cela veut dire que l'insertion s'est mal passée
  */
  public function add($salarie, $modif = 0) {
    /*
    Explication sur le $motif = 0 :
    Si le motif est à 0, on ne passe qu'un paramètre, on ajoute donc une personne et un etudiant/salarie.
    Si le motif est à 1, il s'agit d'une modification.
    On a déjà une personne sur laquelle on souhaite faire un lien vers un etudiant/salarie en ayant detruit son oppose (car changement de catégorie, responsabilité de l'appelant.)
    Il nous reste donc a faire le lien, en tenant compte du numero de personne déjà existant
    */
    if ($modif === 0) {
      parent::add($salarie);
      $lastInsertId = $this->db->lastInsertId();
    } else {
      parent::update($salarie);
      $lastInsertId = $salarie->getPerNum();
      //il s'agit d'un update particulier...
    }

    $sql = "INSERT INTO salarie (per_num, fon_num, sal_telprof)
    VALUES (:per_num, :fon_num, :sal_telprof)";
    $requete = $this->db->prepare ($sql);
    $requete->bindValue(':per_num', $lastInsertId);
    $requete->bindValue(':fon_num', $salarie->getFonNum());
    $requete->bindValue(':sal_telprof', $salarie->getSalTelProf());

    $retour=$requete->execute();
    return $retour;
  }

  public function update($salarie) {
    parent::update($salarie);

    $sql = "UPDATE salarie SET fon_num=:fon_num, sal_telprof=:sal_telprof WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":fon_num", $salarie->getFonNum());
    $requete->bindValue(":sal_telprof", $salarie->getSalTelProf());
    $requete->bindValue(":per_num", $salarie->getPerNum());

    $retour = $requete->execute();
    return $retour;
  }

  public function delete($per_num) {
    $sql = "DELETE FROM salarie WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue("per_num", $per_num);

    $retour = $requete->execute();

    return $retour;
  }

  /*
  *Fonction pour supprimer un utilisateur de salarie uniquement, et non de personne. Utilise pour l'update si on change la catégorie de la personne.
  */
  public function deleteForChange($per_num) {
    $voteManager = new VoteManager($this->db);
    $citationManager = new CitationManager($this->db);

    $citationToDelete = $citationManager->getCitationToDeleteForProf($per_num);

    if (isset($citationToDelete)) {
        foreach ($citationToDelete as $citation) {
          $voteManager->deleteVoteByCitNum($citation->getCitationPerNum());
          $citationManager->deleteCitationByCitNum($citation->getCitationPerNum());
        }
    }

    $citationManager->deleteByPerNum($per_num);

    $sql = "DELETE FROM salarie WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);

    $retour = $requete->execute();
  }

  /*
  Cette fonction permet de retourner un salarié en fonction de son id.
  */
  public function getSalarie($per_num) {
    $sql = 'SELECT s.per_num, s.sal_telprof, s.fon_num, p.per_tel, p.per_mail, p.per_prenom, p.per_nom, p.per_num, p.per_admin, p.per_login, p.per_num FROM salarie s JOIN personne p ON p.per_num=s.per_num WHERE s.per_num='.$per_num;

    $requete = $this->db->prepare($sql);
    $requete->execute();

    $ligne = $requete->fetch(PDO::FETCH_OBJ);
    $personne = new Salarie($ligne);

    $requete->closeCursor();
    return $personne;
  }

  public function getAllSalaries() {
    $listeSalaries = array();

    $sql = "SELECT s.per_num, s.sal_telprof, s.fon_num, p.per_tel, p.per_mail, p.per_prenom, p.per_nom FROM salarie s JOIN personne p ON s.per_num=p.per_num";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($salarie = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeSalaries[] = new Salarie($salarie);
    }

    return $listeSalaries;
  }

}
?>
