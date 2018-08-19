<div id="texte">
<?php
try {
	if (!empty($_GET["page"]) ) {
		if (!intval($_GET["page"])) {
			throw new ExceptionPerso("Merci de ne pas modifier l'URL par vous-même !", ExceptionPerso::ERR_URL);
		}

		$page=$_GET["page"];
	} else {
		$page=0;
	}
	switch ($page) {

				/* ACCUEIL */
				case ACCUEIL:
					include_once('pages/accueil.inc.php');
					break;

				/* PERSONNE */
				case AJOUT_PERSONNE:
					include("pages/ajouterPersonne.inc.php");
				  break;
				case LISTER_PERSONNES:
					include_once('pages/listerPersonnes.inc.php');
					break;
				case MODIFIER_PERSONNE:
					include("pages/modifierPersonne.inc.php");
				  break;
				case SUPPRIMER_PERSONNE:
					include_once('pages/supprimerPersonne.inc.php');
				  break;
				case CHANGER_PWD:
					include_once("pages/changerPwd.inc.php");
					break;

				/* CITATIONS */
				case AJOUTER_CITATION:
			    include("pages/ajouterCitation.inc.php");
			    break;
				case LISTER_CITATIONS:
					include("pages/listerCitation.inc.php");
			    break;
				case VALIDER_CITATIONS:
					include('pages/validerCitations.inc.php');
					break;
				case SUPPRIMER_CITATIONS:
					include('pages/supprimerCitations.inc.php');
					break;
				case RECHERCHER_CITATIONS:
					include('pages/rechercherCitations.inc.php');
					break;
				case VOTER_CITATIONS:
			  	include('pages/voterCitations.inc.php');
				  break;
				case AJOUTER_MOT_INTERDIT:
					include('pages/ajouterMotInterdit.inc.php');
					break;
				case LISTER_MOTS_INTERDITS:
					include('pages/listerMotInterdit.inc.php');
					break;
				case MODIFIER_MOT_INTERDIT:
					include('pages/modifierMotInterdit.inc.php');
					break;

				/* VILLES */
				case AJOUTER_VILLE:
					include("pages/ajouterVille.inc.php");
				    break;
				case LISTER_VILLES:
					include("pages/listerVilles.inc.php");
				    break;
				case MODIFIER_VILLE:
					include("pages/modifierVille.inc.php");
					break;
				case SUPPRIMER_VILLE:
					include("pages/supprimerVille.inc.php");
					break;

				/*AUTRES*/
				case CONNEXION:
					include('pages/connexion.inc.php');
				  break;
				case DECONNEXION:
					include('pages/deconnexion.inc.php');
				  break;

				case INFORMATIONS:
					include('pages/informations.inc.php');
					break;
				case CONTACT:
					include('pages/contact.inc.php');
					break;
				case LISTER_MESSAGES:
					include("pages/listerMessage.inc.php");
					break;

				/*ERREUR 404*/
				default :
					include_once('pages/404.inc.php');
					break;

	}
} catch (ExceptionPerso $e ) {
	include("pages/erreurUser.inc.php");
} catch (Exception $e) {
	//Si jamais on vient à tomber sur une erreur non contrôlée, on l'affiche avec un joli message pour l'utilisateur.
	include("pages/erreurException.inc.php");
}

?>
</div>
