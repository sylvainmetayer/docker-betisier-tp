<script> changerTitre("Voter pour une citation"); </script>
<h1>Voter pour une citation</h1>
<?php
$pdo = new Mypdo();
$citationManager = new CitationManager($pdo);
$personneManager = new PersonneManager($pdo);
$voteManager = new VoteManager($pdo);

if (!isConnected() || !$personneManager->isEtudiant(getPersonneConnectee()->getPerNum()) ) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page. Seul un etudiant peut ajouter une citation !", ExceptionPerso::ERR_DROITS);
}

if (empty($_GET['id'])) {
  throw new ExceptionPerso("Merci de ne pas modifier l'URL de la page", ExceptionPerso::ERR_URL);
} else {
  $citation = $citationManager->getCitation($_GET['id']);

  if (empty($_POST['vot_valeur']) ) {
    $detailsProf = $personneManager->getPersonne($citation->getCitationPerNum());
    $moyenne = $voteManager->getMoyenneVote($citation->getCitationNum());

    include("include/pages/form/voterCitation.form.inc.php");

  } else {
    if ($voteManager->isPerNumDejaVote( getPersonneConnectee()->getPerNum(), $citation->getCitationNum() )) {
      throw new ExceptionPerso("Vous avez déjà voté pour cette citation !", ExceptionPerso::ERR_VOTE);
    }

    $vote = new Vote(
      Array(
        'cit_num' => $citation->getCitationNum(),
        'per_num' => getPersonneConnectee()->getPerNum(),
        'vot_valeur' => $_POST['vot_valeur'] === "zero" ? 0 : $_POST["vot_valeur"]
      ));

    $retour = $voteManager->add($vote);
      if ($retour != 0) {
        afficherMessageSucces("Votre vote a été pris en compte !");
        redirection(1,LISTER_CITATIONS);
    } else {
      afficherMessageErreur("Votre vote n'a pas été pris en compte, il se peut que vous ayiez déjà voté !");
      redirection(5,LISTER_CITATIONS);
    }
  }
}
