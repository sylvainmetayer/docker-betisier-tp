<script> changerTitre("Ajouter une citation"); </script>

<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);
$salarieManager = new SalarieManager($pdo);

if (!isConnected() || !$personneManager->isEtudiant(getPersonneConnectee()->getPerNum()) ) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page. Seul un etudiant peut ajouter une citation !", ExceptionPerso::ERR_DROITS);
}
?>

<h1>Ajouter une citation</h1>

<?php
if (empty($_POST['cit_libelle'])) {
  include("include/pages/form/ajouterCitation.form.inc.php");
  ?><br/><q><?php echo getPhraseAleatoire(); ?></q><?php
} else  {
  $citationManager = new CitationManager($pdo);
  $motManager = new MotManager($pdo);
  $listeMotsInterdits = $motManager->getAllMots();

  if (empty($_POST['cit_libelle'])) {
    throw new ExceptionPerso("Le contenu de la citation ne peut être vide !", ExceptionPerso::ERR_PEBCAK);
  }

  $motCitations = explode(" ", $_POST['cit_libelle']);
  $ajoutAutorise = true;
  $citationFinale = "";

  foreach ($motCitations as $mot) {
    $motclean = strtolower(clean_chaine($mot));
    if ($motManager->isMotExistant($motclean) ) {
      $ajoutAutorise = false;
      $listeMotsInterditsDetectes[] = $mot;
      $citationFinale .= "---";
    } else {
      $citationFinale .= $mot;
    }
    $citationFinale .= " ";
  }

  if (!$ajoutAutorise) {
    include("include/pages/form/ajouterCitationErreur.form.inc.php");

    foreach ($listeMotsInterditsDetectes as $mot) {
      afficherMotInterdit($mot);
    }
    ?><br/><q><?php echo getPhraseAleatoire(); ?></q><?php
  }


  if ($ajoutAutorise) {
    //seul un etudiant peut ajouter une citation sur un prof
		$citation = new Citation(Array(
          'per_num' => $_POST['per_num'], //le prof sur qui est la blague
          'per_num_valide' => NULL, //le numero de la personne qui a valide
          'per_num_etu' => getPersonneConnectee()->getPerNum(), //l'etudiant
          'cit_libelle' => $_POST['cit_libelle'], //la citation
          'cit_date' => $_POST['cit_date_depo'], //la date de depot de la citation, saisie dans le formulaire
          'cit_valide' => 0, //si la citation est validé pour apparaitre en public
          'cit_date_valide' => NULL, //la date a laquelle ça a été validé
          'cit_date_depo' => NULL, //maintenant (pour savoir quand a été déposé la citation), format string --> géré par le manager
        ));
		
        $retour = $citationManager->add($citation);
		
        if ($retour != 0) {
          afficherMessageSucces("Citation ajoutée ! ");
          redirection(2, AJOUTER_CITATION);
        } else {
          afficherMessageErreur("Erreur lors de l'ajout de la citation");
          redirection(5, AJOUTER_CITATION);
        }
  }
}
?>
