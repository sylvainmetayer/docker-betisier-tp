<h2>D&eacute;tails de la citation</h2>

<p>
  Citation sur l'enseignant <?php echo $detailsProf->getPerPrenom()." ".$detailsProf->getPerNom(); ?> en date du <?php echo getFrenchDate($citation->getCitationDateDepot()); ?>.<br/>
  <?php $moyenne ? print "Cette citation a actuellement une moyenne de ".floatval($moyenne) : print "Cette citation n'a pas encore de vote" ; ?>. <br/>
  La citation : <b><?php echo $citation->getCitationLibelle(); ?></b> <br/>
</p>

<form action="#" method="post" class="pure-form pure-form-aligned">
  <div class="pure-control-group">
    <label for="vot_valeur">Votre note <br/>(entre 0 et 20) </label>
    <select name="vot_valeur" id="vot_valeur">
      <option value="zero" selected>0</option>
      <?php
      for ($i = 1; $i <= 20; $i++) {
        ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
      }?>
    </select>
  </div>

  <input type="submit" class="pure-button button-secondary" value="Valider">
</form>
