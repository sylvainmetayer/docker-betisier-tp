<form method="post" action="#" class="pure-form pure-form-aligned">
    <div class="pure-control-group">
      <label for='per_num'>Enseignant</label>
      <select name='per_num' id="per_num">
        <?php
          $personnels = $salarieManager->getAllSalaries();
          foreach ($personnels as $personnel) {
            ?> <option value=' <?php echo $personnel->getPerNum();?>'> <?php echo $personnel->getPerNom(); ?> </option> <?php echo "\n";
          }
        ?>
      </select>

      <label for='cit_date_depo'>Date de la citation</label>
      <input type="text" id="cit_date_depo" name="cit_date_depo" pattern="(0[1-9]|1[0-9]|2[0-9]|3[01])/(0[1-9]|1[012])/[0-9]{4}" placeholder="dd/mm/yyyy" required/>
      <div class="bottomDocument"></div>
      <label for='cit_libelle'> Citation </label>
      <textarea rows="4" cols="50" id="cit_libelle" name="cit_libelle"></textarea>
    </div>


  <input type="submit" class="pure-button button-secondary" value="Valider">
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
      $( "#cit_date_depo" ).datepicker({
        yearRange: '1940:today',
        changeMonth: true,
        changeYear: true,
        maxDate: "+0D",
        showButtonPanel: true
      });
    });
    </script>
</form>
