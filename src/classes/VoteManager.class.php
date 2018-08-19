<?php
class VoteManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  public function add($vote) {
    $sql = "INSERT INTO vote (cit_num, per_num, vot_valeur) VALUES (:cit_num, :per_num, :vot_valeur)";
    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $vote->getPerNum());
    $requete->bindValue(":cit_num", $vote->getCitNum());
    $requete->bindValue(":vot_valeur", $vote->getVotValeur());

    $retour = $requete->execute();
    return $retour;

  }

  public function getVoteEtudiant($per_num, $cit_num) {
    $sql = "SELECT cit_num, per_num, vot_valeur FROM vote WHERE per_num=:per_num AND cit_num=:cit_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);
    $requete->bindValue(":cit_num", $cit_num);

    $requete->execute();

    $tmp = $requete->fetch(PDO::FETCH_OBJ);
    $retour = new Vote($tmp);
    return $retour;
  }


  /** Cette fonction retourne la valeur de vote d'une citation.
  Retourne la valeur directement
  */
  public function getMoyenneVote($cit_num) {
    $sql = "SELECT AVG(vot_valeur) as valeurVote FROM vote WHERE cit_num=:cit_num GROUP BY cit_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":cit_num", $cit_num);

    $requete->execute();
    $retour = $requete->fetch(PDO::FETCH_ASSOC);
    return $retour['valeurVote'];
  }

  /* Cette fonction permet de savoir si un numero d'etudiant a déjà vote ou non pour une citation donnée. Retourne vrai/faux*/
  public function isPerNumDejaVote($per_num, $cit_num) {

      $sql = "SELECT cit_num FROM vote WHERE per_num=:per_num AND cit_num=:cit_num";
      $requete = $this->db->prepare (  $sql );
      $requete->bindValue(":per_num", $per_num);
      $requete->bindValue(":cit_num", $cit_num);

      $retour = $requete->execute ();
      if ($ligne = $requete->fetch ( PDO::FETCH_ASSOC )) {
        $retour = true;
      } else {
        $retour = false;
      }
      $requete->closeCursor();
      return $retour;
  }

  public function deleteVoteByPerNum($per_num) {
    $sql = "DELETE FROM vote WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);

    $requete->bindValue("per_num", $per_num);

    $retour = $requete->execute();
    return $retour;
  }

  public function deleteVoteByCitNum($cit_num) {
    $sql = "DELETE FROM vote WHERE cit_num=:cit_num";

    $requete = $this->db->prepare($sql);

    $requete->bindValue("cit_num", $cit_num);

    $retour = $requete->execute();
    return $retour;
  }

  public function getVoteByPerNum($per_num) {
    $sql = "SELECT cit_num, per_num, vot_valeur FROM vote WHERE per_num=:per_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);

    $retour = $requete->execute();

    while ($vote = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeVote[] = new Vote($vote);
    }

    $requete->closeCursor();
    if (!isset($listeVote)) {
      return null;
    }
    return $listeVote;
  }
}
?>
