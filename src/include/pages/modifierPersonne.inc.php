<script> changerTitre("Modifier une personne"); </script>

<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin() ) {
  throw new ExceptionPerso("Vous ne pouvez pas accéder à cette page !", ExceptionPerso::ERR_DROITS);
}

?> <h1>Modifier une personne enregistrée</h1> <?php

if (empty($_GET['id'])) {
  throw new ExceptionPerso("Merci de ne pas modifier l'url !", ExceptionPerso::ERR_URL);
} else {

  $modifFinie = false;
  $pdo = new Mypdo();
  $personneManager = new PersonneManager($pdo);
  $salarieManager = new SalarieManager($pdo);
  $etudiantManager = new EtudiantManager($pdo);
  $per_num = $_GET['id'];
  $pwdChanged = false;

  if (!is_numeric($per_num)) {
    quitterModifierPersonne();
    throw new ExceptionPerso("Vous ne pouvez pas modifier l'URL !", ExceptionPerso::ERR_PEBCAK);
  }

  $personne = $personneManager->getPersonne($per_num);

  if (empty($personne)) { //personne vide, le numero n'existe pas
    quitterModifierPersonne();
    throw new ExceptionPerso("Le numero saisi ne correspond à aucune personne.", ExceptionPerso::ERR_PERSONNE);
  }

  if (empty( $_POST["per_prenom"]) && empty($_POST['dep_num']) && empty($_POST['sal_telprof']) ) {
    include("include/pages/form/modifPersonne.form.inc.php");
  } else {

    if (!empty($_POST['per_nom'])) {
      // créations variable sessions pour enregistrement temporaire.
      include("include/pages/modifierPersonne.control.inc.php");
    }

    if (!$personneManager->isConnexionAutorisee($personne->getPerLogin(), $_SESSION['verif_pwd'])) {
      quitterModifierPersonne();
      throw new ExceptionPerso("Mot de passe incorrect, modification de la personne impossible !", ExceptionPerso::ERR_PERSONNE);
    }

    if ($_SESSION["categorie"] == "etudiant") {
      include("include/pages/modifierPersonne.etudiant.inc.php");
    } else {
      if($_SESSION['categorie'] == "personnel") {
        include("include/pages/modifierPersonne.salarie.inc.php");
      } else {
        quitterModifierPersonne();
        throw new ExceptionPerso("Merci de ne pas modifier la valeur de categorie. <br/>Cette erreur peut aussi apparaitre si vous essayer de modifier deux fois de suite la meme personne (en rappuyant sur F5 par exemple)", ExceptionPerso::ERR_URL);
      }
    }
  }
}

if ($modifFinie === true) {
  quitterModifierPersonne();
}
