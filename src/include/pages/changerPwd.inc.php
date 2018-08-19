<?php

if (!isConnected() || !is_numeric($_GET['id']) || $_GET['id'] != getPersonneConnectee()->getPerNum()) {
  throw new ExceptionPerso("Bien tenté, mais vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}

?> <h1> Changement de votre mot de passe </h1> <?php
if (empty($_POST['oldPwd']) && empty($_POST['newPwd']) && empty($_POST["newPwdConfirmation"])) {
  include("include/pages/form/modifierPwd.form.inc.php");
} else {
  $pdo = new Mypdo();
  $personneManager = new PersonneManager($pdo);

  if ($_POST["newPwd"] != $_POST["newPwdConfirmation"]) {
    throw new ExceptionPerso("Les mots de passe saisis ne correspondent pas.", ExceptionPerso::ERR_PERSONNE);
  }

  $retour = $personneManager->updatePwd(getPersonneConnectee()->getPerNum(), $_POST['oldPwd'], $_POST['newPwd']);

  if ($retour == true ) {
    afficherMessageSucces("Votre mot de passe a été mis à jour !");
    redirection(1, ACCUEIL);
  } else {
    afficherMessageSucces("Erreur lors de la mise à jour de votre mot de passe..");
    redirection(10, ACCUEIL);
  }
}


?>
