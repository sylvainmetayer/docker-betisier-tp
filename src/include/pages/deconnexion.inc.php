<script>changerTitre("Deconnexion");</script>
<h1>Deconnexion..</h1>

<?php
if (!isConnected()) {
  throw new ExceptionPerso("Vous n'avez pas les droits d'afficher cette page", ExceptionPerso::ERR_DROITS);

}

afficherMessageSucces("Vous avez été déconnecté, à bientôt !");

if (isConnected()) {
  unset($_SESSION['personneConnectee']);
}

redirection(2, ACCUEIL);
?>
