<script> changerTitre("Supprimer une personne"); </script>
<h1> Supprimer une personne </h1>
<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
	throw new ExceptionPerso("Vous n'avez pas les droits nécessaires pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}

if (empty($_GET['id'])) {
		throw new ExceptionPerso("Merci de ne pas modifier l'url !", ExceptionPerso::ERR_URL);
} else {
	$pdo = new Mypdo();
	$personneManager = new PersonneManager($pdo);

	$pernum = $_GET['id'];
	if (!is_numeric($pernum)) {
		throw new ExceptionPerso("Merci de ne pas modifier volontairement les données envoyées !", ExceptionPerso::ERR_URL);
	}

	$retour = $personneManager->deleteByPerNum($pernum);
	if ($retour === true) {
		afficherMessageSucces("Personne supprimée !");
		redirection(1, LISTER_PERSONNES	);
	} else {
		afficherMessageErreur("La personne n'a pas pu être supprimée.");
		redirection(20, LISTER_PERSONNES);
	}

	if ($pernum === getPersonneConnectee()->getPerNum()) {
		afficherMessageSucces("Votre compte a été supprimé, vous allez etre déconnecté..");
		redirection(1, DECONNEXION);
	}
}
?>
