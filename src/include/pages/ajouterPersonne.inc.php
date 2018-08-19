<script> changerTitre("Ajouter une personne"); </script>

<?php
if (!isConnected()) {
  throw new ExceptionPerso("Vous n'avez pas les droits n&eacute;cessaires pour afficher cette page !", ExceptionPerso::ERR_DROITS);
}
$ajoutSucces = false;
?>

<h1>Ajouter une personne</h1>

<?php
//1er passage : Formulaire non complété
if (empty( $_POST["per_prenom"]) && empty($_POST['dep_num']) && empty($_POST['sal_telprof']) ) {
  include("include/pages/form/ajouterPersonne.form.inc.php");
} else {

  if (!empty($_POST['per_nom'])) {
      if ($_POST['per_pwd'] !== $_POST['per_pwd_confirmation']) {
        throw new ExceptionPerso("Les mots de passe saisis ne correspondent pas !", ExceptionPerso::ERR_PERSONNE);
      }

      // créations variable sessions pour enregistrement temporaire.
      $_SESSION['per_nom'] = $_POST['per_nom'];
      $_SESSION['per_prenom'] = $_POST['per_prenom'];
      $_SESSION['per_tel'] = $_POST['per_tel'];
      $_SESSION['per_mail'] = $_POST['per_mail'];
      $_SESSION['per_login'] = $_POST['per_login'];
      $_SESSION['per_pwd'] = $_POST['per_pwd'];
      $_SESSION['categorie'] = $_POST['categorie'];
  }

  if ($_SESSION["categorie"] == "etudiant") {
    if (empty($_POST['dep_num'])) {
      include("include/pages/form/ajouterEtudiant.form.inc.php");
    } else {
        $etudiant=new Etudiant(Array(
          'per_nom' => $_SESSION['per_nom'],
          'per_prenom' => $_SESSION['per_prenom'],
          'per_tel' => $_SESSION['per_tel'],
          'per_mail' => $_SESSION['per_mail'],
          'per_login' => $_SESSION['per_login'],
          'per_pwd' => $_SESSION['per_pwd'],
          'dep_num' => $_POST['dep_num'],
          'div_num' => $_POST['div_num']
        ));

        $etudiantManager = new EtudiantManager($pdo);
        $retour = $etudiantManager->add($etudiant);

        $prenom = $etudiant->getPerPrenom();
        if ($retour != 0) {
            afficherMessageSucces("L'étudiant '$prenom' a été ajouté !");
            $ajoutSucces = true;
            redirection(1, ACCUEIL);
        } else {
          afficherMessageErreur("L'étudiant '$prenom' n'a pas été ajouté !");
          redirection(5, ACCUEIL);
        }
    } //FIN ELSE ETUDIANT
    // FIN ETUDIANT
  } else {
    if($_SESSION['categorie'] == "personnel")
    {
      if(empty($_POST['sal_telprof']))
      {
        include("include/pages/form/ajouterSalarie.form.inc.php");
      } else {
          $salarie=new Salarie(Array(
            'per_nom' => $_SESSION['per_nom'],
            'per_prenom' => $_SESSION['per_prenom'],
            'per_tel' => $_SESSION['per_tel'],
            'per_mail' => $_SESSION['per_mail'],
            'per_login' => $_SESSION['per_login'],
            'per_pwd' => $_SESSION['per_pwd'],
            'sal_telprof' => $_POST['sal_telprof'],
            'fon_num' => $_POST['fon_num']
          ));

          $salarieManager=new SalarieManager($pdo);
          $retour=$salarieManager->add($salarie);

          $prenom = $salarie->getPerPrenom();
          if ($retour != 0) {
              afficherMessageSucces("Le salarié '$prenom' a été ajouté !");
              $ajoutSucces = true;
              redirection(1, ACCUEIL);
          } else {
            afficherMessageErreur("Le salarié '$prenom' n'a pas été ajouté !");
            redirection(5, ACCUEIL);
          }
      }
    } else {
      throw new ExceptionPerso("Merci de ne pas modifier la valeur de categorie. <br/>Cette erreur peut aussi apparaitre si vous essayez d'ajouter deux fois de suite la même personne (en rappuyant sur F5 par exemple)", ExceptionPerso::ERR_URL);
    }
  }
}

if ($ajoutSucces === true) {
  //on en a plus besoin, pas d'interet de les garder.
  unset($_SESSION['per_nom']);
  unset($_SESSION['per_prenom']);
  unset($_SESSION['per_tel']);
  unset($_SESSION['per_mail']);
  unset($_SESSION['per_login']);
  unset($_SESSION['per_pwd']);
  unset($_SESSION['categorie']);
}
?>
