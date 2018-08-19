<?php
if ($_SESSION['pwdChanged']) {
  //on a voulu changé le mot de passe

  $retour = $personneManager->updatePwd($personne->getPerNum(), $_SESSION["verif_pwd"], $_SESSION['per_pwd']);
  if ($retour == false) {
    quitterModifierPersonne();
    throw new ExceptionPerso("Une erreur est survenue lors de la modification du mot de passe de la personne, merci de reessayer ultérieurement. <br/>Vos informations ont été enregistrées, seul le mot de passe n'a pas été mis à jour.", ExceptionPerso::ERR_PERSONNE);
  }
}
?>
