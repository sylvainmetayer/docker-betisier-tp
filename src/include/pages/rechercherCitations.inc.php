<script> changerTitre("Rechercher une citation"); </script>
<h1>Rechercher une citation </h1>

<?php

if (!isConnected()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page ", ExceptionPerso::ERR_DROITS);

}
$pdo = new Mypdo();
if (empty($_POST)) {
  include("include/pages/form/rechercherCitation.form.inc.php");
} else {

  if (empty($_POST['note']) && empty($_POST["date"]) && empty($_POST["prof"])) {
    throw new ExceptionPerso("Il faut remplir au moins un champ lors d'une recherche, sans quoi votre recherche est sans but !", ExceptionPerso::ERR_PEBCAK);
  }

  $note = $_POST["note"];
  $prof = empty($_POST['prof']) ? '' : $_POST['prof'];
  $date = empty($_POST['date']) ? '' : $_POST['date'];

  $recherche = Array(
    'note' => $note,
    'prof' => $prof,
    'date' => $date
  );

  $citationManager = new CitationManager($pdo);

  if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
	  $isAdmin = 0;
  } else {
	  $isAdmin = 1;
  }

  $resultat = $citationManager->search($recherche, $isAdmin);

  if (empty($resultat)) {
    ?>
    <p>
      Aucun résultat trouvé, voulez vous réessayer en modifiant vos critères de recherche ? <br/>
      <a href="index.php?page=<?php echo RECHERCHER_CITATIONS;?>">
        <b> Faire une nouvelle recherche </b>
      </a>
    </p>

    <?php
  } else {
    $voteManager = new VoteManager($pdo);
    $personneManager = new PersonneManager($pdo);
    ?>
    <table class="sortable" >
			<tr>
				<th> &nbsp;Nom de l'enseignant &nbsp;</th>
				<th> Libellé </th>
				<th> Date</th>
				<th> &nbsp; Moyenne des notes &nbsp;</th>
				<?php
				if (isConnected() && $personneManager->isEtudiant(getPersonneConnectee()->getPerNum())) {
				?>
				<th>Noter</th>
				<?php
				}
				if (isConnected() && getPersonneConnectee()->isPerAdmin()) {
				?>
				<th> Déposé par </th>
				<th> Validé par </th>
				<th> Modération </th>
				<th> Supprimer </th>
				<?php
				} ?>
			</tr>
  		<?php
  		foreach ($resultat as $citation) {
  		    include("include/pages/tab/afficherUneCitation.tab.inc.php");
      } ?>
  	</table>
    <a href="index.php?page=<?php echo RECHERCHER_CITATIONS;?>">
      <b> Faire une nouvelle recherche </b>
    </a>
    <div class="bottomDocument"></div>
  <?php
  }
}
