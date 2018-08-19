<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}?>

<script>changerTitre("Ajouter un mot interdit");</script>
<h1> Ajouter un mot interdit </h1>

<?php
if (empty($_POST)) {
  include("include/pages/form/ajouterMotInterdit.form.inc.php");
} else {
  $mot = new Mot($_POST);

  $pdo = new Mypdo();
  $motManager = new MotManager($pdo);

  $retour = $motManager->add($mot);

  if ($retour != 0) {
    afficherMessageSucces("Mot ajouté ! ");
    redirection(1, LISTER_MOTS_INTERDITS);
  } else {
    afficherMessageErreur("Erreur lors de l'ajout du mot..");
    redirection(5, LISTER_MOTS_INTERDITS);
  }
}
