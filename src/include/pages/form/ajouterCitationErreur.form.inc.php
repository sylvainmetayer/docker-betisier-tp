<form action="#" method="post" class="pure-form pure-form-aligned">
    <div class="pure-control-group">
      <label for='per_num'>Enseignant</label>
      <select name='per_num' id="per_num">
        <?php
          $personnels = $salarieManager->getAllSalaries();
          foreach ($personnels as $personnel) {
            if ($personnel->getPerNum() == $_POST['per_num']) {
              ?> <option value=' <?php echo $personnel->getPerNum();?>' selected> <?php echo $personnel->getPerNom(); ?> </option> <?php
              } else {
              ?> <option value=' <?php echo $personnel->getPerNum();?>'> <?php echo $personnel->getPerNom(); ?> </option> <?php
              }
            }
          ?>
      </select>

      <label for='cit_date_depo'>Date de la citation</label>
      <input type="text" id="cit_date_depo" name="cit_date_depo" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" value="<?php echo $_POST['cit_date_depo']; ?>" placeholder="dd/mm/yyyy"/>
      <div class="bottomDocument"></div>
      <label for='cit_libelle'> Citation</label>
      <textarea rows="4" name="cit_libelle" id="cit_libelle" cols="50"><?php echo $citationFinale; ?></textarea>
    </div>
  <input type="submit" class="pure-button button-secondary" value="Valider">
</form>

<div class="bottomDocument"></div>
