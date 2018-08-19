<div id="menu">
	<div id="menuInt" class="pure-menu" >

		<span class="pure-menu-heading">
			<a href="index.php?page=<?php echo ACCUEIL; ?>">
				<img class = "icone" src="image/accueil.gif" alt="Accueil"/> Accueil
			</a>
		</span>

		<?php genererTitreMenu("Personne", "personne.png") ?>
		<ul class="pure-menu-list">
				<?php
				genererItemsMenu("Lister", LISTER_PERSONNES);

				if(isConnected()) {
					genererItemsMenu("Ajouter", AJOUT_PERSONNE);
					genererItemsMenu("Changer votre mot de passe", CHANGER_PWD."&amp;id=".getPersonneConnectee()->getPerNum());
				}

				?>
			</ul>

		<?php genererTitreMenu("Citation", "citation.gif") ?>
		<ul class="pure-menu-list">
				<?php
				if(isConnected() && $personneManager->isEtudiant(getPersonneConnectee()->getPerNum())) {
					genererItemsMenu("Lister", LISTER_CITATIONS);
				}

				//Si la personne est connectée et est un etudiant
				if(isConnected() && $personneManager->isEtudiant(getPersonneConnectee()->getPerNum())) {
					genererItemsMenu("Ajouter", AJOUTER_CITATION);
				}


				if(!isConnected() || !$personneManager->isEtudiant(getPersonneConnectee()->getPerNum())) {
					genererItemsMenu("Lister", LISTER_CITATIONS);
				}

				if (isConnected()) {
					genererItemsMenu("Rechercher", RECHERCHER_CITATIONS);
				}

				//Si ce n'est pas un étudiant, et que c'est un admin.
				if(isConnected() && getPersonneConnectee()->isPerAdmin()) {
					genererItemsMenu("Lister les mots interdits", LISTER_MOTS_INTERDITS);
					genererItemsMenu("Ajouter un mot interdit", AJOUTER_MOT_INTERDIT);
				}
				?>
			</ul>

		<?php genererTitreMenu("Ville", "ville.png") ?>
		<ul class="pure-menu-list">
				<?php
				genererItemsMenu("Lister", LISTER_VILLES);

				if(isConnected()) {
					genererItemsMenu("Ajouter", AJOUTER_VILLE);
				}

				?>
		</ul>

		<span class="pure-menu-heading">
			<a href="index.php?page=<?php echo CONTACT; ?>">
				<img class = "icone" src="image/mail.gif" alt="Contact"/> Contact
			</a>
		</span>

		<ul class="pure-menu-list">
			<?php
				if (isConnected() && getPersonneConnectee()->isPerAdmin()) {
					genererItemsMenu("Voir les messages reçus", LISTER_MESSAGES);
				}
			?>
		</ul>

		<span class="pure-menu-heading">
			<a href="index.php?page=<?php echo INFORMATIONS; ?>">
				<img class = "icone" src="image/information.png" alt="Information"/> Informations
			</a>
		</span>

	</div>
	<br/>
</div>
