<script>changerTitre²("Lister les mots interdits");</script>
<h1>Liste des mots interdits enregistrés </h1>
<?php
if (!isConnected() || !getPersonneConnectee()->isPerAdmin()) {
  throw new ExceptionPerso("Vous n'avez pas les droits pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}

$pdo = new Mypdo();
$motManager = new MotManager($pdo);
$mots = $motManager->getAllMotsObjets();

?>

<?php if (!isset($_GET["mot_id"])) { ?>
  <?php if (count($mots) == 0) {
    ?> <h2>Aucun mot n'est enregistré !</h2>
    <img src="image/no-result.jpg" alt="Pas de résultat !"/><?php
  } else { ?>
    <p>Il y a actuellement <?php echo count($mots); ?> mot(s) enregistré(s).</p>

    <table class="sortable">
      <tr>
        <th>Numero</th>
        <th>Mot</th>
        <th>Modifier</th>
        <th>Supprimer</th>
      </tr>

      <?php
      foreach ($mots as $mot) {
        include("include/pages/tab/afficherUnMotInterdit.tab.inc.php");
      }
      ?>

    </table>
    <div class="bottomDocument"></div>
  <?php }
} else {
  $id = $_GET["mot_id"];

  if (!is_numeric($id)) {
    throw new ExceptionPerso("Merci de ne pas modifier l'URL ! ", ExceptionPerso::ERR_URL);
  }

  $retour = $motManager->deleteById($id);

  if ($retour === true) {
    afficherMessageSucces("Mot supprimé !");
    redirection(1, LISTER_MOTS_INTERDITS);
  } else {
    afficherMessageErreur("Le mot n'a pas pu être supprimé..");
    redirection(5, LISTER_MOTS_INTERDITS);
  }
}
