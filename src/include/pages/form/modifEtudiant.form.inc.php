<?php
$divisionManager = new DivisionManager($pdo);
$departementManager = new DepartementManager($pdo);

$departements = $departementManager->getAllDepartements();
$divisions = $divisionManager->getAllDivisons();

?>

<form action="#" method="post" class="pure-form pure-form-aligned">
  <fieldset>
    <legend>informations sur votre statut &eacute;tudiant</legend>

    <div class="pure-control-group">
      <label for="div_num">Ann&eacute;e </label>
      <select id="div_num" name="div_num">
        <?php
        foreach ($divisions as $division) {
          if ($etudiant->getDivNum() == $division->getDivNum()) {
              ?><option value="<?php echo $division->getDivNum(); ?>" selected> <?php echo $division->getDivNom(); ?>  </option> <?php
          } else {
            ?><option value="<?php echo $division->getDivNum(); ?>"> <?php echo $division->getDivNom(); ?> </option> <?php
          }
        }
        ?>
      </select>
    </div>

    <div class="pure-control-group">
      <label for="dep_num">Département</label>
      <select name="dep_num" id="dep_num">
        <?php
        foreach ($departements as $departement) {
          if ($etudiant->getDepNum() == $departement->getDepNum()) {
            ?><option value="<?php echo $departement->getDepNum(); ?>" selected> <?php echo $departement->getDepNom(); ?> </option> <?php
          } else {
            ?><option value="<?php echo $departement->getDepNum(); ?>"> <?php echo $departement->getDepNom(); ?> </option> <?php
          }
        }
        ?>
      </select>
    </div>
  </fieldset>

  <input type="submit" class="pure-button button-secondary" value="Valider">
</form>
