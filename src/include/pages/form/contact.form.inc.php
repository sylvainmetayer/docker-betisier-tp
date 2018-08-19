<p>
  Des idées, une erreur sur le site, ou vous souhaitez tout simplement me contacter ? <br/>
  Remplissez ce formulaire, et je répondrais le plus vite à votre demande. <br/>
  <i>Les champs précédés d'une étoile (*) sont obligatoire</i>
</p>
<div class="bottomDocument"></div>
<form class="pure-form pure-form-aligned" action="#" method="post">
  <div class="pure-control-group">
    <label for="prenom">*Prénom</label>
    <?php if (isConnected()) {
      ?><input type="text" name="prenom" id="prenom" value="<?php echo getPersonneConnectee()->getPerPrenom(); ?>" required><?php
    } else {
      ?><input type="text" name="prenom" id="prenom" required><?php
    } ?>


    <label for="nom">*Nom</label>
    <?php if (isConnected()) { ?>
      <input type="text" name="nom" id="nom" value="<?php echo getPersonneConnectee()->getPerNom(); ?>" required>
    <?php } else { ?>
      <input type="text" name="nom" id="nom" required>
    <?php } ?>


  </div>

  <div class="pure-control-group">
    <label for="mail">*Mail</label>
    <?php if (isConnected()) { ?>
    <input type="email" name="mail" id="mail" value="<?php echo getPersonneConnectee()->getPerMail(); ?>" required>
    <?php } else { ?>
    <input type="email" name="mail" id="mail" required>
    <?php } ?>
    <label for="sujet">Sujet de la demande </label>
    <input type="text" name="sujet" id="sujet">
  </div>

  <div class="pure-control-group">
    <label for="message">*Votre demande</label> <br/>
    <textarea name="message" id="message" rows="8" cols="40" required></textarea>
  </div>

  <i>Markdown autorisé</i><br/><br/>
  <input type="submit" class="pure-button button-secondary" value="Valider">
</form>
<div class="bottomDocument"> </div>
