<tr>
  <td> <?php echo $mot->getMotId() ?> </td>
  <td> <?php echo $mot->getMotInterdit() ?> </td>
  <td>
    <a href="index.php?page=<?php echo MODIFIER_MOT_INTERDIT."&amp;mot_id=".$mot->getMotId(); ?>" title="Modifier">
      <img src="image/modifier.png" alt="Modifier mot"/>
    </a>
  </td>
  <td>
    <a href="index.php?page=<?php echo LISTER_MOTS_INTERDITS."&amp;mot_id=".$mot->getMotId(); ?>" title="Modifier">
      <img src="image/erase.png" alt="Supprimer mot"/>
    </a>
  </td>
</tr>
