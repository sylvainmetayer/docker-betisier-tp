<?php
class FonctionManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  /*Retourne un objet fonction */
  public function getFonctionLibelle($fon_num) {
    $sql = "SELECT fon_libelle, fon_num FROM fonction WHERE fon_num=:fon_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":fon_num", $fon_num);
    $requete->execute();

    $ligne = $requete->fetch(PDO::FETCH_OBJ);
    $fonction = new Fonction($ligne);

    $requete->closeCursor();
    return $fonction;
  }

  /* Retourne un tableau d'objet Fonctions contenant toutes les fonctions */
  public function getAllFonctions() {
      $listeFonctions = array();

      $sql = "SELECT fon_num, fon_libelle FROM fonction";

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($fonction = $requete->fetch(PDO::FETCH_OBJ)) {
        $listeFonctions[] = new Fonction($fonction);
      }

      return $listeFonctions;
    }
}
