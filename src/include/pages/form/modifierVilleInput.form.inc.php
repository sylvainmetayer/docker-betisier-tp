<form action="#" method="post" class="pure-form pure-form-aligned">
  <div class="pure-control-group">
    <label for="vil_nom">Nouveau nom de la ville</label>
    <input type="text" name="vil_nom" value="<?php echo $ville->getVilleNom(); ?>" required>
  </div>

  <input type="submit" class="pure-button button-secondary" value="Modifier">
</form>
