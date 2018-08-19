<script> changerTitre("Lister les citations"); </script>

<?php
$pdo = new Mypdo();
$citationManager = new CitationManager($pdo);

if (!isConnected()) {
	$nbCitations = $citationManager->getNbCitations();
	$nbCitationsCorrecte = $citationManager->getNbCitationsCorrectes();
	$nbCitationsListees = 2;
	$tmp = $citationManager->getAllCitations();
	if ($nbCitationsCorrecte < $nbCitationsListees) {
		//Dans le cas ou une seule citation a été modérée.
		$nbCitationsListees = $nbCitationsCorrecte;
	}
	for ($i = 0; $i < $nbCitationsListees; $i++) {
		//On restreint l'affichage pour les personnes connectées.
		$citations[] = $tmp[$i];
	}

}

if (isConnected() && !getPersonneConnectee()->isPerAdmin()) {
	$citations = $citationManager->getAllCitations();
	$nbCitations = count($citations);
}

if (isConnected() && getPersonneConnectee()->isPerAdmin()) {
	$citations = $citationManager->getAllCitationsAdmin();
	$nbCitations = count($citations);
}

$personneManager = new PersonneManager($pdo);
$voteManager = new VoteManager($pdo);
if (intval($nbCitations) === 0) {
	?> <h1>Aucune citation n'est enregistrée ! </h1>

	<img src="image/no-result.jpg" alt="Pas de résultat !"/> <?php
} else {

	?>
		<h1>Liste des citations déposées</h1>

		<p>
			Actuellement, <?php echo $nbCitations; ?> citations sont enregistrées.
			<?php
			if (!isConnected()) {
				?>
				<br/>Seules les <?php echo $nbCitationsListees; ?> premières seront listées ici.
				<?php
			}
			?>
		</p>

		<?php
		if (isConnected() && getPersonneConnectee()->isPerAdmin()) {
			if ( count($citationManager->getCitationsEnAttente()) > 0) {
				?>
				<p>
					<img src="image/work.gif" alt="Au travail"/>	Il reste <?php echo count($citationManager->getCitationsEnAttente()); ?> citation(s) à modérer<br/>
					<img src="image/erreur.png" alt="Refuser la citation"/> Refuser la citation <br/>
					<img src="image/valid.png" alt="Approuver la citation"/> Approuver la citation <br/>
					<img src="image/approuvee.ico" alt="Citation approuvée"/> Déjà modérée, et approuvée <br/>
					<img src="image/non-approuver.png" alt="Citation refusée"/> Déjà modérée, et refusée <br/>

				</p>

				<?php
			} else {
				afficherMessageSucces("Toutes les citations ont été validées !");
			}

		}?>

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
			foreach ($citations as $citation) {
				include("include/pages/tab/afficherUneCitation.tab.inc.php");
			} ?>
		</table> <?php
} ?>
	<div class="bottomDocument"></div>
