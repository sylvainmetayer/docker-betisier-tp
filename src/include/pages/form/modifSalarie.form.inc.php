<?php // ATTENTION A L'APPELANT ! ?>

<form action="#" method="post" class="pure-form pure-form-aligned">
    <fieldset>
      <legend>Informations sur votre statut de salari&eacute;</legend>

      <div class="pure-control-group">
        <label for="sal_telprof">T&eacute;l&eacute;phone professionnel :</label>
        <input type='tel' id="sal_telprof" name='sal_telprof' value="<?php echo $salarie->getSalTelProf(); ?>" required>
      </div>

      <div class="pure-control-group">
        <label for="fon_num">Fonction :</label>
        <select name="fon_num" id="fon_num">
          <?php
           $fonctionManager=new FonctionManager($pdo);
           $fonctions=$fonctionManager->getAllFonctions();

           foreach ($fonctions as $fonction)
           {
             if ($salarie->getFonNum() == $fonction->getFonNum()) {
               ?><option value="<?php echo $fonction->getFonNum(); ?>" selected> <?php echo $fonction->getFonLibelle(); ?> </option> <?php
             } else {
               ?><option value="<?php echo $fonction->getFonNum(); ?>"> <?php echo $fonction->getFonLibelle(); ?> </option> <?php
             }
           }
           ?>
        </select>
      </div>

    </fieldset>
    <input type="submit" class="pure-button button-secondary" value="Valider">
</form>
<div class="bottomDocument"></div>
