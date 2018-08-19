<script> changerTitre("Modifier une ville"); </script>

<?php
if (!isConnected()) {
  throw new ExceptionPerso("Vous n'avez pas le droit d'afficher cette page !", ExceptionPerso::ERR_DROITS);
}

$pdo = new Mypdo();
$villeManager = new VilleManager($pdo);
?>

<h1> Modifier une ville </h1>

<?php
if (empty($_GET['vil_num'])) {
  throw new ExceptionPerso("Merci de ne pas modifier l'url !", ExceptionPerso::ERR_URL);
} else {

  $ville = $villeManager->getVille($_GET['vil_num']);

  if (empty($ville)) {
    throw new Exception("La ville n'existe pas.", ExceptionPerso::ERR_VILLE);
  }

  if (empty($_POST['vil_nom'])) {
    include("include/pages/form/modifierVilleInput.form.inc.php");
  } else {
    $ville->setVilleNom($_POST['vil_nom']);

    $retour = $villeManager->update($ville);
    if ($retour != 0) {
      afficherMessageSucces("Ville modifiée !");
      redirection(1, LISTER_VILLES);
    } else {
      afficherMessageErreur("La ville n'a pas été modifiée..");
      redirection(5, LISTER_VILLES);
    }
  }
}
?>
