<script> changerTitre("Lister les villes"); </script>

<?php
$pdo = new Mypdo();
$villeManager = new VilleManager($pdo);
$villes = $villeManager->getAllVilles();

if (count($villes) !== 0) {
	?>
		<h1>Liste des villes</h1>

		<p> Actuellement, <?php echo count($villes); ?> villes sont enregistrées. </p>

		<table class="sortable">
			<tr>
				<th>Numero</th>
				<th>Nom</th>
				<?php if (isConnected()) {
					?>
					<th>Modifier </th>
					<?php
				}
				if (isConnected() && getPersonneConnectee()->isPerAdmin()) {
					?>
					<th> Supprimer </th>
					<?php
				} ?>
			</tr>
			<?php
			foreach ($villes as $ville) {
				include("include/pages/tab/afficherUneVille.tab.inc.php");
	 		} ?>
		</table>
		<?php
} else {
	?> <h1>Aucune ville n'est enregistrée ! </h1>

	<img src="image/no-result.jpg" alt="Pas de résultat !"/><?php
}
