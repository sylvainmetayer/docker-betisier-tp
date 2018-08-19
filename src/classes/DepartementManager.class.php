<?php
class DepartementManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  /*Retourne un tableau associatif avec le nom de departement et le nom de la ville associée */
  public function getDetailsDepartement($dep_num) {
    $sql = 'SELECT dep_nom, vil_nom FROM departement d JOIN ville v on v.vil_num=d.vil_num WHERE dep_num='.$dep_num;

    $requete = $this->db->prepare($sql);
    $requete->execute();

    $ligne = $requete->fetch(PDO::FETCH_ASSOC);

    $requete->closeCursor();
    return $ligne;
  }

  /*Retourne tous les départements enregistrés.*/
  public function getAllDepartements() {
    $listeDepartements = array();

    $sql = "SELECT dep_num, dep_nom FROM departement";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($departement = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeDepartements[] = new Departement($departement);
    }

    return $listeDepartements;
  }

  public function delete($dep_num) {
    $sql = "DELETE FROM departement WHERE dep_num=:dep_num";

    $requete = $this->db->prepare($sql);

    $requete->bindValue("dep_num", $dep_num);
    $retour = $requete->execute();
    return $retour;
  }



}
