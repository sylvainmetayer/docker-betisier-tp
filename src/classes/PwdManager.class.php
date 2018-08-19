<?php
class PwdManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function isPwdForbidden($pwd) {
    $sql = "SELECT pwd_libelle FROM pwd WHERE pwd_libelle=:pwd";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":pwd", $pwd);

    $requete->execute();

    $resultat = $requete->fetch ( PDO::FETCH_OBJ );
    if ($resultat != null)
    {
      return new Pwd ( $resultat );
    } else {
      return null;
    }

  }

}
