<?php
class CitationManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  /* Prend en paramètre un objet citation, et l'ajoute dans la base de données. Retourne qqch != 0 si l'insertion s'est mal passée. */
  public function add($citation) {
    $sql = "INSERT INTO citation (per_num, per_num_valide, per_num_etu, cit_libelle, cit_date, cit_valide, cit_date_valide, cit_date_depo)
    VALUES (:per_num, :per_num_valide, :per_num_etu, :cit_libelle, :cit_date, :cit_valide, :cit_date_valide, NOW())";

    $requete = $this->db->prepare($sql);

    $requete->bindValue(":per_num", $citation->getCitationPerNum());
    $requete->bindValue(":per_num_valide", $citation->getCitationPerNumValide());
    $requete->bindValue(":per_num_etu", $citation->getCitationPerNumEtu());
    $requete->bindValue(":cit_libelle", $citation->getCitationLibelle());
    $requete->bindValue("cit_valide", false);
    $requete->bindValue("cit_date_valide", $citation->getCitationDateValide());
    $dateDepot = getEnglishDate($citation->getCitationDate());
    $requete->bindValue("cit_date", $dateDepot);

    $retour = $requete->execute();
    return $retour;
  }

  /*
  Permet d'effectuer une recherche avec un tableau passé en paramètre, contenant une note, une date et un prof. Les données peuvent-être vide.
  Le $code dans les if est uniquement utilisé à des fins de test.

  */
  public function search($recherche, $isAdmin) {
	if (!$isAdmin) {
		$hide = " AND cit_valide = 1 AND cit_date_valide IS NOT NULL";
	} else {
		$hide = "";
	}

    $sql = "SELECT c.cit_num, c.per_num, per_num_etu, per_num_valide, cit_libelle, cit_date, cit_date_depo, cit_date_valide, cit_valide ";

    /*
    TABLE DE VERITE
    note	prof	date
    0	0	0 OK
    0	0	1 OK
    0	1	0 OK
    0	1	1 OK
    1	0	0 OK
    1	0	1 OK
    1	1	0 OK
    1	1	1 OK
    */

    if ($recherche['note'] === "novalue") {
      $note = "";
    } else if ($recherche['note'] == "zero") {
      $note = "zero";
    } else {
      $note = floatval($recherche['note']);
    }

    if (empty($note) && empty($recherche["prof"]) && empty($recherche["date"])) {
      $code = 1;
      throw new ExceptionPerso("Une recherche ne peut s'effectuer sans critères de recherches !", ExceptionPerso::ERR_CITATION);
    }

    if (empty($note) && empty($recherche["prof"]) && !empty($recherche["date"])) {
      $code = 2;
      $sql .= " FROM citation c WHERE cit_date=:date";
	  $sql .= $hide;
      $requete = $this->db->prepare($sql);
      $requete->bindValue(":date", getEnglishDate($recherche["date"]));
    }

    if (empty($note) && !empty($recherche["prof"]) && empty($recherche["date"])) {
      $code = 3;
      $sql .= " FROM citation c WHERE c.per_num=:prof ";
	  $sql .= $hide;
      $requete = $this->db->prepare($sql);
      $requete->bindValue(":prof", $recherche["prof"]);
    }

    if (empty($note) && !empty($recherche["prof"]) && !empty($recherche["date"])) {
      $code = 4;
      $sql .= " FROM citation c WHERE cit_date=:date AND c.per_num=:prof ";
	  $sql .= $hide;
      $requete = $this->db->prepare($sql);
      $requete->bindValue(":date", getEnglishDate($recherche["date"]));
      $requete->bindValue(":prof", $recherche["prof"]);
    }

    if (!empty($note) && empty($recherche["prof"]) && empty($recherche["date"])) {
      $code = 5;
	  if (!$isAdmin) {
		$sql .= " FROM citation c JOIN vote v ON c.cit_num=v.cit_num WHERE cit_valide=1 AND cit_date_valide IS NOT NULL GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  } else {
		$sql .= " FROM citation c JOIN vote v ON c.cit_num=v.cit_num GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  }
      $requete = $this->db->prepare($sql);
      $requete->bindValue(":note", $note === "zero" ? 0 : floatval($note));
    }

    if (!empty($note) && empty($recherche["prof"]) && !empty($recherche["date"])) {
      $code = 6;
	  if (!$isAdmin) {
		$sql .= " FROM citation c JOIN vote v on v.cit_num=c.cit_num WHERE cit_date=:date AND cit_valide=1 AND cit_date_valide IS NOT NULL GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  } else {
		$sql .= " FROM citation c JOIN vote v on v.cit_num=c.cit_num WHERE cit_date=:date GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  }
      $requete = $this->db->prepare($sql);
      $requete->bindValue(":note", $note === "zero" ? 0 : floatval($note));
      $requete->bindValue(":date", getEnglishDate($recherche["date"]));
    }

    if (!empty($note) && !empty($recherche["prof"]) && empty($recherche["date"])) {
      $code = 7;
	  if (!$isAdmin) {
		$sql .= " FROM citation c JOIN vote v on v.cit_num=c.cit_num WHERE c.per_num=:prof AND cit_valide=1 AND cit_date_valide IS NOT NULL GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  } else {
		$sql .= " FROM citation c JOIN vote v on v.cit_num=c.cit_num WHERE c.per_num=:prof GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  }
      $requete = $this->db->prepare($sql);
      $requete->bindValue(":note", $note === "zero" ? 0 : floatval($note));
      $requete->bindValue(":prof", $recherche["prof"]);
    }

    if (!empty($note) && !empty($recherche["prof"]) && !empty($recherche["date"])) {
      $code = 8;
	  if (!$isAdmin) {
		$sql .= " FROM citation c JOIN vote v on v.cit_num=c.cit_num WHERE c.per_num=:prof AND cit_date=:date AND cit_valide=1 AND cit_date_valide IS NOT NULL GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  } else {
		$sql .= " FROM citation c JOIN vote v on v.cit_num=c.cit_num WHERE c.per_num=:prof AND cit_date=:date GROUP BY c.cit_num HAVING AVG(vot_valeur)=:note";
	  }

      $requete = $this->db->prepare($sql);
      $requete->bindValue(":note", $note === "zero" ? 0 : floatval($note));
      $requete->bindValue(":date", getEnglishDate($recherche["date"]));
      $requete->bindValue(":prof", $recherche["prof"]);
    }

    //TRES utile en phase de test !
    //echo $code."- ".$sql;

    $requete->execute();

    $citations = "";

    while ($ligne = $requete->fetch(PDO::FETCH_OBJ)) {
      $citations[] = new Citation($ligne);
    }

    return $citations;
  }

  /*Permet de supprimer une citation et ses dépendances via un numéro de citation.*/
  public function deleteByCitNum($cit_num) {
    $sql = "DELETE FROM vote WHERE cit_num=:cit_num;
            DELETE FROM citation WHERE cit_num=:cit_num";

    $requete = $this->db->prepare($sql);

    $requete->bindValue(":cit_num", $cit_num);

    $retour = $requete->execute();
    return $retour;
  }

  public function deleteByPerNum($per_num) {
    $sql = "DELETE from vote WHERE cit_num IN (SELECT c.cit_num FROM citation c WHERE per_num_etu = :per_num);
            DELETE FROM vote WHERE per_num=:per_num;
            DELETE FROM citation WHERE per_num=:per_num OR per_num_etu=:per_num OR per_num_valide=:per_num; ";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);

    $retour = $requete->execute();
    return $retour;
  }

  /*Permet de modérer une citation. */
  public function modererCitation($citation) {

    if ($citation->getCitationValide() == 0) {
      $sql = "UPDATE citation SET per_num_valide=:per_num_valide, cit_date_valide=NOW(), cit_valide=0 WHERE cit_num=:cit_num ";
      $requete = $this->db->prepare($sql);
    }
    if ($citation->getCitationValide() == 1) {
      $sql = "UPDATE citation SET per_num_valide=:per_num_valide, cit_date_valide=NOW(), cit_valide=:cit_valide WHERE cit_num=:cit_num ";
      $requete = $this->db->prepare($sql);
      $requete->bindValue(":cit_valide", 1);
    }

    $requete->bindValue(":per_num_valide", $citation->getCitationPerNumValide());
    $requete->bindValue(":cit_num", $citation->getCitationNum());


    $retour = $requete->execute();
    return $retour;
  }

  /*Retourne toutes les citations. DOIT UNIQUEMENT ETRE UTILISE POUR L'ADMIN, CAR AFFICHE TOUTES LES CITATIONS, MEME NON MODEREES.*/
  public function getAllCitationsAdmin() {
    $listeCitations = array();
    $sql = "SELECT cit_num,per_num,per_num_valide,per_num_etu,cit_libelle,cit_date,cit_valide,cit_date_valide,cit_date_depo FROM citation";
    $requete = $this->db->prepare($sql);
    $requete->execute();
    while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeCitations[] = new Citation($citation);
    }
    $requete->closeCursor();
    return $listeCitations;
  }

  public function getAllCitations() {
    $listeCitations = array();
    $sql = 'SELECT cit_num,per_num,per_num_valide,per_num_etu,cit_libelle,cit_date,cit_valide,cit_date_valide,cit_date_depo FROM citation c WHERE cit_valide=1 AND cit_date_valide is not null ORDER BY cit_date_depo desc';

    $requete = $this->db->prepare($sql);

    $requete->execute();

    while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeCitations[] = new Citation($citation);
    }
    $requete->closeCursor();
    return $listeCitations;
  }

  /*Permet de retourner une citation via son numero*/
  public function getCitation($cit_num) {
    $sql = 'SELECT cit_num,per_num,per_num_valide,per_num_etu,cit_libelle,cit_date,cit_valide,cit_date_valide,cit_date_depo FROM citation c WHERE cit_num='.$cit_num;

    $requete = $this->db->prepare($sql);

    $requete->execute();

    $ligne = $requete->fetch(PDO::FETCH_OBJ);
    $citation = new Citation($ligne);
    //$citation->ctrlSaisie = new ControleurSaisie();
    $requete->closeCursor();
    return $citation;
  }

  /* Cette fonction permet de savoir le nombre de citations présentes et validées dans la base de donnes.
  Retourne le résultat directement
  */
  public function getNbCitationsCorrectes() {
    $sql = "SELECT count(*) as nbCitation FROM citation WHERE cit_date_valide is not null and cit_valide = 1";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    $retour = $requete->fetch(PDO::FETCH_ASSOC);
    return $retour['nbCitation'];
  }

  public function getCitationsEnAttente() {
    $sql = "SELECT cit_num,per_num,per_num_valide,per_num_etu,cit_libelle,cit_date,cit_valide,cit_date_valide,cit_date_depo FROM citation WHERE cit_date_valide is null and cit_valide = 0 ";

    $listeCitations = null;
    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeCitations[] = new Citation($citation);
    }
    $requete->closeCursor();
    return $listeCitations;
  }

  /*Pour un eleve donnée, retourne les citation a supprimer*/
  public function getCitationToDeleteForStudent($per_num) {
    $sql = "SELECT cit_num,per_num,per_num_valide,per_num_etu,cit_libelle,cit_date,cit_valide,cit_date_valide,cit_date_depo FROM citation WHERE per_num_etu=:per_num OR per_num=:per_num OR per_num_valide=:per_num";
    //Normalement, on devrait juste mettre per_num_etu, mais étant donné qu'il y a sophie delmas, on est obligé d'ajouter les deux autres.
    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);
    $requete->execute();

    while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeCitations[] = new Citation($citation);
    }
    $requete->closeCursor();
    if (isset($listeCitations)) {
      return $listeCitations;
    }
    return null;

  }

  /*Pour un prof donnée, retourne les citation à supprimer.*/
  public function getCitationToDeleteForProf($per_num) {
    $sql = "SELECT cit_num,per_num,per_num_valide,per_num_etu,cit_libelle,cit_date,cit_valide,cit_date_valide,cit_date_depo FROM citation WHERE per_num=:per_num OR per_num_valide=:per_num";
    $requete = $this->db->prepare($sql);
    $requete->bindValue(":per_num", $per_num);
    $requete->execute();

    while ($citation = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeCitations[] = new Citation($citation);
    }
    $requete->closeCursor();
    if (isset($listeCitations)) {
      return $listeCitations;
    }
    return null;

  }

  public function deleteCitationByCitNum($cit_num) {
    $sql = "DELETE FROM citation WHERE cit_num=:cit_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue(":cit_num", $cit_num);

    $retour = $requete->execute();
    return $retour;
  }

  /* Cette fonction permet de savoir le nombre de citations présentes dans la base de données.
  Retourne le résultat directement
  */
  public function getNbCitations() {
    $sql = "SELECT count(*) as nbCitation FROM citation";

    $requete = $this->db->prepare($sql);

    $requete->execute();

    $retour = $requete->fetch(PDO::FETCH_ASSOC);
    return $retour['nbCitation'];
  }

  /*Retourne la citation ayant la meilleure note*/
  public function getTopCitation() {
    $sql = "SELECT c.cit_num, c.per_num, c.per_num_etu, c.per_num_valide, c.cit_libelle, c.cit_valide, c.cit_date, c.cit_date_depo, c.cit_date_valide FROM citation c JOIN vote v ON v.cit_num=c.cit_num WHERE cit_valide=1 AND cit_date_valide IS NOT NULL GROUP BY c.cit_num HAVING AVG(vot_valeur) >=ALL (SELECT AVG(vot_valeur) as Moyenne FROM citation c JOIN vote v ON v.cit_num=c.cit_num WHERE cit_valide=1 AND cit_date_valide IS NOT NULL GROUP BY c.cit_num )";
    $requete = $this->db->prepare($sql);

    $requete->execute();

    $tmp = $requete->fetch(PDO::FETCH_OBJ);
    $tmp ? $resultat = new Citation($tmp) : $resultat = null;
    return $resultat;
  }

}
?>
