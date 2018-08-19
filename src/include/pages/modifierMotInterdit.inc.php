<script>changerTitre("Modifier un mot interdit");</script>
<h1>Modifier un mot interdit</h1>

<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}

if (empty($_GET['mot_id']) || !is_numeric($_GET['mot_id'])) {
  throw new ExceptionPerso("Merci de ne pas modifier l'URL de la page !", ExceptionPerso::ERR_URL);
}

$pdo = new Mypdo();
$motManager = new MotManager($pdo);

$mot = $motManager->getMotById($_GET['mot_id']);

if (empty($_POST['mot_interdit'])) {
  include("include/pages/form/modifierMotInterdit.form.inc.php");
} else {
  $mot->setMotInterdit($_POST['mot_interdit']);

  $retour = $motManager->update($mot);

  if ($retour === true) {
    afficherMessageSucces("Mot mis à jour !");
    redirection(1, LISTER_MOTS_INTERDITS);
  } else {
    afficherMessageErreur("Le mot n'a pas pu être mis à jour..");
    redirection(5, LISTER_MOTS_INTERDITS);
  }
}
