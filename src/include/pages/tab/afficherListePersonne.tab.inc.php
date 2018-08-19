<table class="sortable">
  <tr>
    <th>Numero</th>
    <th>Nom</th>
    <th>Prenom</th>
    <?php
    if (isConnected() && getPersonneConnectee()->isPerAdmin() ) {
    ?>
    <th>Modifier</th>
    <th>Supprimer</th>
    <?php } ?>
  </tr>
  <?php
  foreach ($personnes as $personne) {
    ?> <tr>
        <?php if (isConnected() && getPersonneConnectee()->getPerNum() == $personne->getPerNum()) {
          ?> <td> <b> <a href="index.php?page=<?php echo LISTER_PERSONNES; ?>&amp;id=<?php echo  $personne->getPerNum(); ?>" > <?php echo $personne->getPerNum(); ?> (vous) </a> </b> </td>
        <?php } else {
          ?> <td> <b> <a href="index.php?page=<?php echo LISTER_PERSONNES; ?>&amp;id=<?php echo  $personne->getPerNum(); ?>" > <?php echo $personne->getPerNum(); ?> </a> </b> </td> <?php
        } ?>
        <td> <a href="index.php?page=<?php echo LISTER_PERSONNES; ?>&amp;id=<?php echo  $personne->getPerNum(); ?>" > <?php echo $personne->getPerNom(); ?> </a> </td>
        <td> <a href="index.php?page=<?php echo LISTER_PERSONNES; ?>&amp;id=<?php echo  $personne->getPerNum(); ?>" > <?php echo $personne->getPerPrenom(); ?> </a> </td>
        <?php
        if (isConnected() && getPersonneConnectee()->isPerAdmin() ) {
        ?>
        <td> <a href="index.php?page=<?php echo MODIFIER_PERSONNE.'&amp;id='.$personne->getPerNum(); ?>"> <img src="image/modifier.png" alt="Modifier <?php echo $personne->getPerPrenom(); ?>" title="Modifier <?php echo $personne->getPerPrenom(); ?>"/> </a> </td>
        <td> <a href="index.php?page=<?php echo SUPPRIMER_PERSONNE.'&amp;id='.$personne->getPerNum(); ?>"> <img src="image/erreur.png" alt="Supprimer <?php echo $personne->getPerPrenom(); ?>" title="Supprimer <?php echo $personne->getPerPrenom(); ?>"/> </a> </td>
        <?php } ?>
      </tr>
  <?php } ?>
</table>
<div class="bottomDocument"></div>
