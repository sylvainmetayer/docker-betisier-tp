<script> changerTitre("Valider une citation"); </script>
<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin() ) {
  throw new ExceptionPerso("Vous ne pouvez pas accéder à cette page !", ExceptionPerso::ERR_DROITS);
}

$pdo = new Mypdo();
$citationManager = new CitationManager($pdo);
$citationsEnAttente = $citationManager->getCitationsEnAttente();
?>

<h1>Valider une citation </h1>
<?php

if (empty($_GET['cit_num']) && empty($_GET['cit_valide'])) {
  throw new ExceptionPerso("Merci de ne pas modifier l'URL.", ExceptionPerso::ERR_URL);
} else {
  $citation = $citationManager->getCitation($_GET["cit_num"]);
  if ($_GET['cit_valide'] === "zero") {
    $citation->setCitationValide(0);
  } else {
  $citation->setCitationValide(intval($_GET['cit_valide']));
  }
  $citation->setCitationPerNumValide(getPersonneConnectee()->getPerNum());

  $retour = $citationManager->modererCitation($citation);

  if ($retour != 0) {
    afficherMessageSucces("La citation a été modérée !");
    redirection(1, LISTER_CITATIONS);
  } else {
    afficherMessageErreur("Une erreur est survenue. La citation n'a pas été modérée");
    redirection(5, LISTER_CITATIONS);
  }
}
?>
