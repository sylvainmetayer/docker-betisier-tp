<script>changerTitre("Messages reçus");</script>

<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);

}

?>
<h1>Messages reçus</h1>

<?php

$mail = implode(lireFichier(SIMUL_MAIL));

if (strlen($mail) == 0) {
  afficherMessageErreur('Aucun message reçu !');
} else {
  $parsedown = new Parsedown();

  echo $parsedown->text($mail);
}

?>


<div class="bottomDocument"></div>
