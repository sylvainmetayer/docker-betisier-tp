  <?php
  //ATTENTION A L'APPELANT !
  if ($detailPersonne->isPerAdmin()) {
    ?> <img alt="avatar <?php echo $detailPersonne->getPerPrenom(); ?>" src="image/avatars/rootAvatar.gif" /> <?php
  } else {
    $nb = rand(1,getNbFile("image/avatars", "jpg")); ?>
    <img alt="avatar <?php echo $detailPersonne->getPerPrenom(); ?>" src="image/avatars/<?php echo $nb; ?>.jpg" /> <?php
  } ?>
  <?php $divisionManager = new DivisionManager($pdo);?>
  <table class="tableDetailPersonne sortable">
    <tr>
      <th>Pr&eacute;nom</th>
      <th>Mail</th>
      <th>T&eacute;l&eacute;phone</th>
      <?php if ($personneManager->isEtudiant($id)) {
        ?>
        <th>D&eacute;partement</th>
        <th>Ville</th>
      <?php } else {
        ?>
          <th>T&eacute;l&eacute;phone professionnel</th>
          <th>Fonction</th>
        <?php
      } ?>
    </tr>
    <tr>
      <td> <?php echo $detailPersonne->getPerPrenom(); ?> </td>
      <td> <?php isConnected() ? print $detailPersonne->getPerMail() : print maskData($detailPersonne->getPerMail()); ?> </td>
      <td> <?php isConnected() ? print $detailPersonne->getPerTel() : print maskData($detailPersonne->getPerTel()); ?> </td>
      <?php if ($personneManager->isEtudiant($id)) {
        $division = $divisionManager->getDivision($detailPersonne->getDivNum());
        ?>
          <td> <?php isConnected() ? print $detailsDepartement['dep_nom'].", ".$division->getDivNom() : print maskData($detailsDepartement['dep_nom'].", ".$division->getDivNom()); ?> </td>
          <td> <?php isConnected() ? print $detailsDepartement['vil_nom'] : print maskData($detailsDepartement['vil_nom']); ?> </td>
        <?php } else {
          ?>
          <td> <?php isConnected() ? print $detailPersonne->getSalTelprof() : print maskData($detailPersonne->getSalTelprof()); ?> </td>
          <td> <?php isConnected() ? print $fonction->getFonLibelle() : print maskData($fonction->getFonLibelle()); ?> </td>
          <?php } ?>
    </tr>
  </table>
  <p>Appuyez sur F5 pour un autre avatar !</p>

  <?php if (!isConnected()) {
    ?>
    <p><a href="index.php?page=<?php echo CONNEXION; ?>">Connectez-vous pour vous les détails de cette personne !</a></p>
    <?php
  } ?>
  <div class="bottomDocument"></div>
