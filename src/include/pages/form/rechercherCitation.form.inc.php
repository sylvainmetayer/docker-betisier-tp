<script> changerTitre("Rechercher une citation"); </script>

<form class="pure-form pure-form-aligned" method="post" action="#">
  <?php
    $salarieManager = new SalarieManager($pdo);
    $salaries = $salarieManager->getAllSalaries();
  ?>
  <div class="pure-control-group">
    <label for="prof">Par professeur</label>
    <select name="prof" id="prof">
      <option value="" selected>
        Faites votre choix ou laissez cette option pour ignorer
      </option>
      <?php foreach ($salaries as $salarie) {
      ?>
      <option value="<?php echo $salarie->getPerNum(); ?>">
        <?php echo $salarie->getPerPrenom()." ".$salarie->getPerNom(); ?>
      </option>
      <?php
      }
      ?>
    </select>
  </div>

  <div class="pure-control-group">
    <label for="note">
      Par moyenne 
    </label>
    <select name="note" id="note">
      <option value="novalue"  selected>
        Faites votre choix ou laissez cette option pour ignorer
      </option>
      <option value="zero">0</option>
      <option value="0.50" >0.5</option>
      <?php
      for ($i = 1; $i < 20; $i++) {
        for ($j = 0 ; $j < 100 ; $j+=50) {
        ?><option value="<?php echo $i.".".$j; ?>"><?php echo $i.".".$j; ?></option><?php
        }
      }?>
      <option value="20" >20</option>
    </select>
  </div>

  <div class="pure-control-group">
    <label for="date">
      Par date de dépôt
    </label>
    <input type="text" name="date" id="date" placeholder="dd/mm/yyyy" size="43" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}">
  </div>

  <script>
  (function( factory ) {
  	if ( typeof define === "function" && define.amd ) {

  		// AMD. Register as an anonymous module.
  		define([ "../jquery.ui.datepicker" ], factory );
  	} else {

  		// Browser globals
  		factory( jQuery.datepicker );
  	}
  }(function( datepicker ) {
  	datepicker.regional['fr'] = {
  		closeText: 'Fermer',
  		prevText: 'Précédent',
  		nextText: 'Suivant',
  		currentText: 'Aujourd\'hui',
  		monthNames: ['janvier', 'février', 'mars', 'avril', 'mai', 'juin',
  			'juillet', 'août', 'septembre', 'octobre', 'novembre', 'décembre'],
  		monthNamesShort: ['janv.', 'févr.', 'mars', 'avril', 'mai', 'juin',
  			'juil.', 'août', 'sept.', 'oct.', 'nov.', 'déc.'],
  		dayNames: ['dimanche', 'lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi', 'samedi'],
  		dayNamesShort: ['dim.', 'lun.', 'mar.', 'mer.', 'jeu.', 'ven.', 'sam.'],
  		dayNamesMin: ['D','L','M','M','J','V','S'],
  		weekHeader: 'Sem.',
  		dateFormat: 'dd/mm/yy',
  		firstDay: 1,
  		isRTL: false,
  		showMonthAfterYear: false,
  		yearSuffix: ''};
  	datepicker.setDefaults(datepicker.regional['fr']);

  	return datepicker.regional['fr'];

  }));

  $(function() {
    //$( "#date" ).datepicker( $.datepicker.regional[ "fr" ] );
    $( "#date" ).datepicker({
      yearRange: '1940:today',
      changeMonth: true,
      changeYear: true,
      maxDate: "+0D",
      showButtonPanel: true
    });
  });
  </script>
  <div class="bottomDocument"></div>
  <input type="submit" class="pure-button button-secondary" id="validerRecherche" value="Rechercher">
</form>
