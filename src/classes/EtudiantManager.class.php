<?php
/*Cette classe étend le comportement de PersonneManager */
class EtudiantManager extends PersonneManager {

  public function __construct($db) {
    parent::__construct($db);
    $this->db = $db;
  }

  /*
  Cette fonction permet d'ajouter un étudiant, en l'ajoutant d'abord dans la table personne.
  Si cette fonction retourne quelque chose différent de 0, cela veut dire que l'insertion s'est mal passée
  */
  public function add($etudiant, $modif = 0) {
    /*
    Explication sur le $motif = 0 :
    Si le motif est à 0, on ne passe qu'un paramètre, on ajoute donc une personne et un etudiant/salarie.
    Si le motif est à 1, il s'agit d'une modification.
    On a déjà une personne sur laquelle on souhaite faire un lien vers un etudiant/salarie en ayant detruit son oppose (car changement de catégorie, responsabilité de l'appelant.)
    Il nous reste donc a faire le lien, en tenant compte du numero de personne déjà existant
    */
    if ($modif === 0) {
      parent::add($etudiant);
      $lastInsertId = $this->db->lastInsertId();
    } else {
      parent::update($etudiant);
      $lastInsertId = $etudiant->getPerNum();
      //il s'agit d'un update particulier...
    }

    $sql = "INSERT INTO etudiant (per_num, dep_num, div_num)
    VALUES (:per_num, :dep_num, :div_num)";
    $requete = $this->db->prepare ($sql);
    $requete->bindValue(':per_num', $lastInsertId);
    $requete->bindValue(':dep_num', $etudiant->getDepNum());
    $requete->bindValue(':div_num', $etudiant->getDivNum());

    $retour=$requete->execute();
    return $retour;
  }

  /*Cette fonction permet de mettre à jour un eleve, et la personne associée.*/
  public function update($etudiant) {
    parent::update($etudiant);

    $sql = "UPDATE etudiant SET dep_num=:dep_num, div_num=:div_num WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":dep_num", $etudiant->getDepNum());
    $requete->bindValue(":div_num", $etudiant->getDivNum());
    $requete->bindValue(":per_num", $etudiant->getPerNum());

    $retour = $requete->execute();
    return $retour;
  }

  /*cette fonction permet de supprimer un étudiant et la personne associée. DOIT etre utilisée avec le delete de personneManager*/
  public function delete($per_num) {
    $sql = "DELETE FROM etudiant WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue("per_num", $per_num);

    $retour = $requete->execute();

    return $retour;
  }

  public function deleteForChange($per_num) {
    $voteManager = new VoteManager($this->db);
    $citationManager = new CitationManager($this->db);

    $citationToDelete = $citationManager->getCitationToDeleteForStudent($per_num);

    if (isset($citationToDelete)) {
        foreach ($citationToDelete as $citation) {
          $voteManager->deleteVoteByCitNum($citation->getCitationPerNum());
          $citationManager->deleteCitationByCitNum($citation->getCitationPerNum());
        }
    }

    $citationManager->deleteByPerNum($per_num);

    $sql = "DELETE FROM vote WHERE per_num=:per_num; DELETE FROM citation WHERE per_num_etu=:per_num; DELETE FROM etudiant WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);

    $retour = $requete->execute();
  }

  /*Retourne un étudiant*/
  public function getEtudiant($per_num) {
    $sql = 'SELECT e.per_num, dep_num, div_num, per_tel, per_mail,  per_prenom, per_nom, p.per_num, p.per_admin, p.per_login, p.per_num FROM etudiant e JOIN personne p ON p.per_num=e.per_num WHERE e.per_num='.$per_num;

    $requete = $this->db->prepare($sql);
    $requete->execute();

    $ligne = $requete->fetch(PDO::FETCH_OBJ);
    $personne = new Etudiant($ligne);

    $requete->closeCursor();
    return $personne;
  }

}
?>
