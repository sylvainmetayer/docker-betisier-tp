<script> changerTitre("Lister les personnes"); </script>

<?php
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);
$personnes = $personneManager->getAllPersonnes();
?>

<?php
	if (empty ( $_GET ['id'] )) {
		//id non renseigné, on affiche toutes les personnes.
		?>
			<h1>Liste des personnes enregistrées</h1>
			<?php if ($personnes == null) { // Pas de personnes enregistrées
					?>
					<p> D&eacute;sol&eacute;, aucune personne n'est enregistr&eacute;e.</p>
					<img src="image/no-result.jpg" alt="Pas de résultat !"/>
					<?php
				} else { // Des personnes sont enregistrées ?>
					<p>
						Actuellement, <?php echo count($personnes); ?> personnes sont enregistr&eacute;es. <br/>
						Cliquez sur une personne pour afficher plus de détails.
					</p>
					<?php
					include("include/pages/tab/afficherListePersonne.tab.inc.php");
				}

	} else {

			$id = $_GET['id'];
			if (!intval($id) || !$personneManager->isPerNumExistant($id)) {
				throw new ExceptionPerso("Merci de ne pas modifier l'url dans la barre d'adresse !", ExceptionPerso::ERR_URL);
			}

			if ($personneManager->isEtudiant($id)) {
				$etudiantManager = new EtudiantManager($pdo);
				$departementManager = new DepartementManager($pdo);

				$detailPersonne = $etudiantManager->getEtudiant($id);

				$detailsDepartement = $departementManager->getDetailsDepartement($detailPersonne->getDepNum());
				?> <h1> D&eacute;tail sur l'étudiant <?php echo $detailPersonne->getPerNom(); ?> </h1><?php
			} else {
					$salarieManager = new SalarieManager($pdo);
					$fonctionManager = new FonctionManager($pdo);

					$detailPersonne = $salarieManager->getSalarie($id);

					$fonction = $fonctionManager->getFonctionLibelle($detailPersonne->getFonNum());
					?> <h1> D&eacute;tail sur le salari&eacute; <?php echo $detailPersonne->getPerNom(); ?> </h1><?php
			}
			include("include/pages/tab/afficherDetailsPersonne.tab.inc.php");
	}
?>
