<script> changerTitre("Supprimer une citation"); </script>

<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}
?>

<h1>Supprimer une citation </h1>

<?php
$pdo = new Mypdo();
$citationManager = new CitationManager($pdo);
$voteManager = new VoteManager($pdo);

if (empty($_GET['id'])) {
  throw new ExceptionPerso("Merci de ne pas modifier l'URL", ExceptionPerso::ERR_URL);
} else {
  $cit_num = $_GET['id'];
  if (empty($cit_num) || !is_numeric($cit_num)) {
    throw new ExceptionPerso("Merci de ne pas modifier l'URL !", ExceptionPerso::ERR_URL);
  }
  $retour = $citationManager->deleteByCitNum($cit_num);
  if ($retour === true) {
    afficherMessageSucces("Citation supprimée !");
    redirection(1, LISTER_CITATIONS);
  } else {
      afficherMessageErreur("La citation n'a pas pu être supprimée.");
      redirection(5, LISTER_CITATIONS);
  }

}
