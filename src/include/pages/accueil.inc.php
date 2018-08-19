<script> changerTitre("Accueil"); </script>
<?php
$pdo = new Mypdo();
$citationManager = new CitationManager($pdo);
$citation = $citationManager->getTopCitation();
$voteManager = new VoteManager($pdo);
$personneManager = new PersonneManager($pdo);

if (is_null($citation)) {
  ?><h2>Aucune top citation à lister !</h2> <?php
} else {
?>
<h2> Actuellement, la meilleure citation est... </h2>

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

  <?php include("include/pages/tab/afficherUneCitation.tab.inc.php"); ?>
</table>
<?php }

$version = explode(".",phpversion());
if (intval($version[0]) < 5 || intval($version[1]) < 5) {
  ?>
  <p>
     <a href="index.php?page=<?php echo CONTACT; ?>">Ce site se trouve sur un serveur dont la version de PHP est ancienne. <br/>Peut-être devriez vous penser à contacter le responsable du site pour l'avertir ?</a>
  </p>
  <?php
}
?>

<p>
  Identifiant élève : Paul / Mot de passe : IUT <br/>
  Identifiant prof : Bob / Mot de passe : IUT <br/>
  Identifiant admin : mc / Mot de passe : IUT <br/>
</p>

<img class="centreImage" src="image/logo.gif" alt="Betisier IUT" title="Betisier IUT Limousin"/>
<div class="bottomDocument"></div>
