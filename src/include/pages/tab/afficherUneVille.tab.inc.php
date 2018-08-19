<tr>
  <td> <?php echo $ville->getVilleNum(); ?> </td>
  <td> <?php echo $ville->getVilleNom(); ?> </td>
  <?php if (isConnected()) {
    ?>
    <td>
      <a href="index.php?page=<?php echo MODIFIER_VILLE."&amp;vil_num=".$ville->getVilleNum(); ?>" title="Modifier <?php echo $ville->getVilleNom(); ?>">
        <img src="image/modifier.png" alt="Modifier"/>
      </a>
    </td>
    <?php
  }
  if (isConnected() && getPersonneConnectee()->isPerAdmin()) {
    ?>
    <td>
      <a href="index.php?page=<?php echo SUPPRIMER_VILLE."&amp;vil_num=".$ville->getVilleNum(); ?>" title="Supprimer <?php echo $ville->getVilleNom(); ?>">
        <img src="image/erreur.png" alt="Supprimer"/>
      </a>
    </td>
    <?php
  } ?>
</tr>
