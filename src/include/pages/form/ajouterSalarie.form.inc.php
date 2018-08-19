<form action="#" method="post" class="pure-form pure-form-aligned">

  <div class="pure-control-group">
    <label for="sal_telprof">T&eacute;l&eacute;phone professionnel</label>
    <input type='tel' name='sal_telprof' id="sal_telprof" required>
  </div>

  <div class="pure-control-group">
    <label for="fon_num">Fonction </label>
    <select name="fon_num" id="fon_num" >
      <?php
       $fonctionManager=new FonctionManager($pdo);
       $fonctions=$fonctionManager->getAllFonctions();

       foreach ($fonctions as $fonction)
       {
         ?>
         <option value="<?php echo $fonction->getFonNum(); ?>"> <?php echo $fonction->getFonLibelle(); ?> </option>
         <?php
       }
       ?>
    </select>
  </div>

  <input type="submit" class="pure-button button-secondary" value="Valider">
</form>
