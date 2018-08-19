<script> changerTitre("Supprimer une ville"); </script>

<?php

if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}
?>
<h1>Supprimer une ville </h1>
<script>changerTitre("Supprimer une ville");</script>

<?php
if (empty($_GET['vil_num'])) {
  throw new ExceptionPerso("Merci de ne pas modifier l'url !", ExceptionPerso::ERR_URL);
} else {
  $pdo = new Mypdo();
  $villeManager = new VilleManager($pdo);
  $vil_num = $_GET['vil_num'];

  $retour = $villeManager->delete($vil_num);

  if ($retour === true) {
    afficherMessageSucces("Ville supprimée !");
    redirection(1, LISTER_VILLES);
  } else {
    afficherMessageErreur("La ville n'a pas pu être supprimée. Elle est probablement utilisée par des étudiants qu'il faut supprimer avant !.");
    redirection(5, LISTER_VILLES);
  }
}

?>
