<?php

if (!empty($_POST['per_pwd']) && !empty($_POST['per_pwd_confirmation']) && $_POST['per_pwd'] !== $_POST['per_pwd_confirmation']) { //il a voulu changer son mot de passe, et les mots de passe ne correspondent pas
  quitterModifierPersonne();
  throw new ExceptionPerso("Les mots de passe saisis ne correspondent pas !", ExceptionPerso::ERR_PERSONNE);
}

if ($_POST["categorie"] == "etudiant" && $personne->isPerAdmin()) {
  //L'admin veut devenir étudiant, on rejete sa demande !
  quitterModifierPersonne();
  throw new ExceptionPerso("Un administrateur ne peut devenir étudiant ! ", ExceptionPerso::ERR_PERSONNE);
}

$_SESSION['per_nom'] = $_POST['per_nom'];
$_SESSION['per_prenom'] = $_POST['per_prenom'];
$_SESSION['per_tel'] = $_POST['per_tel'];
$_SESSION['per_mail'] = $_POST['per_mail'];
$_SESSION['per_login'] = $_POST['per_login'];
$_SESSION['verif_pwd'] = $_POST['verif_pwd'];
$_SESSION['categorie'] = $_POST['categorie'];

if (!isset($_SESSION["pwdChanged"])) { //Pour faire le controle uniquement après le remplissage du formulaire de personne.

  if (empty($_POST['per_pwd'])) { //pas de changement de pwd
    $_SESSION['pwdChanged'] = false;
  } else { //changement de pwd

    if ($_POST['per_pwd'] != $_POST['per_pwd_confirmation'] ) {
      quitterModifierPersonne();
      throw new ExceptionPerso("Les mots de passe saisis ne correspondent pas !", ExceptionPerso::ERR_PERSONNE);
    }

    $_SESSION['per_pwd'] = $_POST['per_pwd'];
    $_SESSION['per_pwd_confirmation'] = $_POST['per_pwd_confirmation'];

    $_SESSION['pwdChanged'] = true;
  }
}

if (empty($_SESSION['verif_pwd'])) {
  quitterModifierPersonne();
  throw new ExceptionPerso("Merci de saisir votre mot de passe pour modifier la personne !", ExceptionPerso::ERR_PERSONNE);
}
?>
