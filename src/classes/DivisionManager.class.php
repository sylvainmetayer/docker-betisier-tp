<?php
class DivisionManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  /* Retourne un tableau d'objet Division */
  public function getAllDivisons() {
    $listeDivisions = array();

    $sql = "SELECT div_num, div_nom FROM division";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($division = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeDivisions[] = new Division($division);
    }

    return $listeDivisions;
  }

  public function getDivision($div_num) {
    $sql = "SELECT div_num,div_nom FROM division WHERE div_num=:div_num";
    $requete = $this->db->prepare($sql);
    $requete->bindValue(":div_num", $div_num);
    $requete->execute();
    $ligne = $requete->fetch(PDO::FETCH_OBJ);
    $division = new Division($ligne);
    $requete->closeCursor();
    return $division;
  }

}


?>
