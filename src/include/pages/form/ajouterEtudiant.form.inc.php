<?php
$divisionManager = new DivisionManager($pdo);
$divisions = $divisionManager->getAllDivisons();
$departementManager = new DepartementManager($pdo);
$departements = $departementManager->getAllDepartements();
?>

<form action="#" method="post" name="formulaireEtudiant" class="pure-form pure-form-aligned">
    <div class="pure-control-group">
      <label for="div_num">Ann&eacute;e </label>
      <select name="div_num" id="div_num">
        <?php
        foreach ($divisions as $division) {
          ?><option value="<?php echo $division->getDivNum(); ?>"> <?php echo $division->getDivNom(); ?> </option> <?php
        }
        ?>
      </select>
      <label for="dep_num">Département </label>
      <select name="dep_num" id="dep_num">
        <?php
        foreach ($departements as $departement) {
          ?><option value="<?php echo $departement->getDepNum(); ?>"> <?php echo $departement->getDepNom(); ?> </option> <?php
        }
        ?>
      </select>
    </div>
    <br/>

  <input type="submit" class="pure-button button-secondary" value="Valider">
</form>
