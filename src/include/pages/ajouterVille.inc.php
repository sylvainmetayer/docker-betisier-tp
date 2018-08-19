<script> changerTitre("Ajouter une ville"); </script>

<?php if (!isConnected()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);
} ?>

<h1>Ajouter une ville</h1>

<?php
if (empty( $_POST)) {
  include("include/pages/form/ajouterVille.form.inc.php");
} else {
  $pdo = new Mypdo();
  $villeManager = new VilleManager($pdo);

  $ville = new Ville($_POST);
  $retour = $villeManager->add($ville);

  if ($retour != 0) { // OK
    afficherMessageSucces("La ville <b>".$ville->getVilleNom()."</b> &agrave; &eacute;t&eacute; ajout&eacute;e !");
    redirection(1 ,ACCUEIL);
  } else {
    afficherMessageErreur("La ville <b>".$ville->getVilleNom()."</b> n'&agrave; pas &eacute;t&eacute; ajout&eacute;e..");
    redirection(5,ACCUEIL);
  }
}
?>
