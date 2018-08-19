<script> changerTitre("Modifier un salarié"); </script>

<?php
$salarie = $salarieManager->getSalarie($personne->getPerNum());

if(empty($_POST['sal_telprof'])) {
  include("include/pages/form/modifSalarie.form.inc.php");
} else {

    $salarie=new Salarie(Array(
    'per_num' => $personne->getPerNum(),
      'per_nom' => $_SESSION['per_nom'],
      'per_prenom' => $_SESSION['per_prenom'],
      'per_tel' => $_SESSION['per_tel'],
      'per_mail' => $_SESSION['per_mail'],
      'per_login' => $_SESSION['per_login'],
      'sal_telprof' => $_POST['sal_telprof'],
      'fon_num' => $_POST['fon_num']
    ));

    if ($personneManager->isEtudiant($salarie->getPerNum())) {
      //cela veut dire que l'on a changé sa catégorie, et que c'était un etudiant avant, donc on le drop et on ajoute un salarie tout nouveau !
      $etudiantManager->deleteForChange($salarie->getPerNum());
      $retour = $salarieManager->add($salarie, 1);
    } else {
      // "simple" update
      $retour = $salarieManager->update($salarie);
    }

    include("include/pages/modifierPersonne.pwd.inc.php");

    $prenom = $salarie->getPerPrenom();
    $modifFinie = true; //dans les deux cas, on va unset.
    if ($retour != 0) { // OK
      afficherMessageSucces("Le salarié '$prenom' a été modifié !");
      redirection(1,LISTER_PERSONNES);
    } else {
      afficherMessageErreur("Le salarié '$prenom' n'a pas été modifié !");
      redirection(10,LISTER_PERSONNES);
    }
}
?>
