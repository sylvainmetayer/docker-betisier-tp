<?php
class VilleManager {
  private $db;

  public function __construct($db) {
    $this->db = $db;
  }

  /*
  Cette fonction permet d'ajouter une ville dans la base de données.
  */
  public function add($ville) {

		if ($this->isExistanteVille ( $ville->getVilleNom () )) { // la ville existe déjà
			throw new ExceptionPerso("Le nom de la ville existe d&eacute;j&agrave; ! Il est impossible d'ajouter deux fois la m&ecirc;me ville.", ExceptionPerso::ERR_VILLE);
		}
    $sql = 'INSERT INTO ville (vil_nom) VALUES (:ville);';
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ':ville', $ville->getVilleNom () );

		$retour = $requete->execute ();
		return $retour;
	}

  public function update($ville) {

    if ($this->isExistanteVille ( $ville->getVilleNom () )) { // la ville existe déjà
			throw new ExceptionPerso("Le nom de la ville existe d&eacute;j&agrave; ! Il est impossible d'ajouter deux fois la m&ecirc;me ville.", ExceptionPerso::ERR_VILLE);
		}

    $sql = "UPDATE ville SET vil_nom=:vil_nom WHERE vil_num=:vil_num";
    $requete = $this->db->prepare ( $sql );
    $requete->bindValue ( ':vil_num', $ville->getVilleNum () );
    $requete->bindValue ( ':vil_nom', $ville->getVilleNom () );

    $retour = $requete->execute ();
    return $retour;
  }

  public function getVille($vil_num) {
    $sql = "SELECT vil_num,vil_nom FROM ville WHERE vil_num=:vil_num";
    $requete = $this->db->prepare($sql);
    $requete->bindValue(":vil_num", $vil_num);
    $requete->execute();
    $ligne = $requete->fetch(PDO::FETCH_OBJ);
    $ville = new Ville($ligne);
    $requete->closeCursor();
    return $ville;
  }

  /*Permet de savoir si une ville est liée a un étudiant ou seulement a un département en vue de sa suppression.*/
  public function isVilleNumDejaUtilise($vil_num) {
    $sql = "SELECT v.vil_num FROM ville v JOIN departement d ON d.vil_num=v.vil_num JOIN etudiant e ON e.dep_num=d.dep_num WHERE v.vil_num=:ville";

    $requete = $this->db->prepare($sql);

    $requete->bindValue(":ville", $vil_num);

    $retour = $requete->execute();
    $resultat = $requete->fetch(PDO::FETCH_OBJ);
    if (empty($resultat)) {
      return false;
    }
    return true;
  }

  public function delete($vil_num) {

    $listePerNum = $this->getListeEtudiantInVille($vil_num);
    $listeDepNum = $this->getListeDepartementInVille($vil_num);

    if (isset($listePerNum) && !is_null($listePerNum)) {
      $personneManager = new PersonneManager($this->db);
      foreach ($listePerNum as $key => $value) {
        $personneManager->deleteByPerNum($value);
      }
    }

    if (isset($listeDepNum) && !is_null($listeDepNum)) {
      $departementManager = new DepartementManager($this->db);
      foreach ($listeDepNum as $cle => $valeur) {
        $departementManager->delete($valeur);
      }
    }

    $sql = "DELETE FROM ville WHERE vil_num=:vil_num";

    $requete = $this->db->prepare($sql);
    $requete->bindValue("vil_num", $vil_num);

    $retour = $requete->execute();
    return $retour;
  }

  /*Fonction utilisée pour la suppression de villes, afin de savoir les étudiants dépendants.*/
  public function getListeEtudiantInVille($vil_num) {
    $sql = "SELECT per_num FROM etudiant e JOIN departement d on d.dep_num=e.dep_num JOIN ville v on v.vil_num=d.vil_num WHERE v.vil_num=:vil_num";

    $requete = $this->db->prepare($sql);

    $requete->bindValue("vil_num", $vil_num);

    $requete->execute();

    while ($pernum = $requete->fetch(PDO::FETCH_ASSOC)) {
      $listePerNum[] = $pernum["per_num"];
    }
    $requete->closeCursor();
    if (!isset($listePerNum) || is_null($listePerNum)) {
      return null;
    }
    return $listePerNum;
  }

  /*Retourne la liste des departement concerne par la suppression d'une ville*/
  public function getListeDepartementInVille($vil_num) {
    $sql = "SELECT d.dep_num FROM departement d WHERE vil_num=:vil_num";

    $requete = $this->db->prepare($sql);

    $requete->bindValue("vil_num", $vil_num);

    $requete->execute();

    while ($depnum = $requete->fetch(PDO::FETCH_ASSOC)) {
      $listeDepNum[] = $depnum["dep_num"];
    }
    $requete->closeCursor();
    if (!isset($listeDepNum) || is_null($listeDepNum)) {
      return null;
    }
    return $listeDepNum;
  }

  /*
  Cette fonction permet de verifier que l'on ajoute pas une ville qui existe deja.
  Retourne true si la ville existe déjà, false sinon.
  */
	public function isExistanteVille($vil_nom) {
		$sql = "SELECT vil_num, vil_nom FROM ville WHERE vil_nom=:vil_nom ";
		$requete = $this->db->prepare ( $sql );
		$requete->bindValue ( ":vil_nom", $vil_nom );

		$requete->execute ();

		$resultat = $requete->fetch ( PDO::FETCH_OBJ );

		if ($resultat != null) // La ville existe déjà
    {
			return true;
		} else {
			return false;
		}
	}

  public function isExistanteVilleById($vil_num) {
    $sql = "SELECT vil_num, vil_nom FROM ville WHERE vil_num=:vil_num ";
    $requete = $this->db->prepare ( $sql );
    $requete->bindValue ( ":vil_num", $vil_num );

    $requete->execute ();

    $resultat = $requete->fetch ( PDO::FETCH_OBJ );

    if ($resultat != null) // La ville existe déjà
    {
      return true;
    } else {
      return false;
    }
  }



  /*
  Fonction qui permet de lister toutes les villes présente dans la base de données.
  Retourne un tableau d'objet Ville
  */
  public function getAllVilles() {
    $listeVilles = array();

    $sql = 'SELECT vil_num, vil_nom FROM ville';

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($ville = $requete->fetch(PDO::FETCH_OBJ)) {
      $listeVilles[] = new Ville($ville);
    }
    $requete->closeCursor();
    return $listeVilles;
  }

  /*
  Cette fonction permet de savoir le nombre de villes présentes dans la base de données.
  Retourne directement la valeur.
  */
  public function getNbVilles() {
    $sql = "SELECT count(vil_num) as nbVille FROM ville";

    $requete = $this->db->prepare($sql);
    $requete->execute();

    $retour = $requete->fetch(PDO::FETCH_ASSOC);
    return $retour['nbVille'];
  }
}
?>
