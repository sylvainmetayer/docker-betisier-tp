<script> changerTitre("Modifier un étudiant"); </script>
<?php
$etudiant = $etudiantManager->getEtudiant($personne->getPerNum());

if (empty($_POST['dep_num'])) {
  include("include/pages/form/modifEtudiant.form.inc.php");
} else {
  $etudiant=new Etudiant(Array(
    'per_num' => $personne->getPerNum(),
    'per_nom' => $_SESSION['per_nom'],
    'per_prenom' => $_SESSION['per_prenom'],
    'per_tel' => $_SESSION['per_tel'],
    'per_mail' => $_SESSION['per_mail'],
    'per_login' => $_SESSION['per_login'],
    'dep_num' => $_POST['dep_num'],
    'per_admin' => $personne->isPerAdmin(),
    'div_num' => $_POST['div_num']
  ));

  if (!$personneManager->isEtudiant($etudiant->getPerNum())) {
    //cela veut dire que l'on a changé sa catégorie, et que c'était un salarie avant, donc on le drop et on ajoute un etudiant tout nouveau !
    $salarieManager->deleteForChange($etudiant->getPerNum());
    $retour = $etudiantManager->add($etudiant, 1);
  } else {
    // "simple" update
    $retour = $etudiantManager->update($etudiant);
  }

  include("include/pages/modifierPersonne.pwd.inc.php");

  $prenom = $etudiant->getPerPrenom();
  $modifFinie = true; //dans les deux cas, on va supprimer les variables de session
  if ($retour != 0) { // OK
    afficherMessageSucces("L'étudiant '$prenom' a été modifié !");
    redirection(1,LISTER_PERSONNES);
  } else {
    afficherMessageErreur("L'étudiant '$prenom' n'a pas été modifié !");
    redirection(10,LISTER_PERSONNES);
  }
} //FIN ELSE ETUDIANT
// FIN ETUDIANT
?>
