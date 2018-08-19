<form action="#" method="post" class="pure-form pure-form-aligned">
  <div class="pure-control-group">
    <label for="mot_interdit">Modification du mot </label>
    <input type="text" name="mot_interdit" value="<?php echo $mot->getMotInterdit(); ?>" required>
  </div>
  
  <input type="submit" class="pure-button button-secondary" value="Modifier">
</form>
