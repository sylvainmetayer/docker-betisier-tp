<script> changerTitre("Connexion"); </script>
 <h1>Pour vous connecter</h1>
<?php
$pdo = new Mypdo ();
$personneManager = new PersonneManager ( $pdo );

if (empty ( $_POST ['per_login'] ) || empty ( $_POST ['per_pwd'] ) || empty ( $_POST ['reponse'] )) {
  // choix aléatoires des deux nombres pour le captcha
  //echo getNbFile("image/nb", "jpg");
  $nb1 = rand ( 1, getNbFile("image/nb", "jpg") );
  $nb2 = rand ( 1, getNbFile("image/nb", "jpg") );
  $_SESSION['reponseCaptcha'] = $nb1 + $nb2;
	?>

    <?php
    include("include/pages/form/connexion.form.inc.php");
} else {

    if (isset($_SESSION['reponseCaptcha'])) {
      $resultat = $_SESSION['reponseCaptcha']; // resultat attendu.
    } else {
      $resultat = '';
    }

  	$reponseUser = $_POST ['reponse']; // réponse utilisateur

    // détails de la connexion + verification details connexion
  	$login = $_POST ['per_login'];
  	$pwd = $_POST ['per_pwd'];
  	$connexionOK = $personneManager->isConnexionAutorisee ( $login, $pwd);

  	if ($reponseUser != $resultat) {
  		$captcha = false;
      // captcha incorrect
      afficherMessageErreur("Le captcha est incorrect");
  		?>
      <a href="index.php?page=<?php echo CONNEXION; ?>"> <b>Reessayer ?</b> </a>
      <?php
      if (isset ($_SESSION['reponseCaptcha'])) {
        //il faudra générer un nouveau captcha, celui la n'est plus utile.
        unset($_SESSION['reponseCaptcha']);
      }
  	} else {
  		$captcha = true;
  		// captcha correct

      if ($connexionOK == false) {
        // mauvais mot de passe/identifiant
        afficherMessageErreur("Erreur d'identifiant/mot de passe");
    		?>
          <a href="index.php?page=<?php echo CONNEXION; ?>"><b>Reessayer ?</b></a>
        <?php
        if (isset ($_SESSION['reponseCaptcha'])) {
          //il faudra générer un nouveau captcha, celui la n'est plus utile.
          unset($_SESSION['reponseCaptcha']);
        }
    	 }

       if (($connexionOK == true) && $captcha == true) {
         $personneConnecte = $personneManager->getPersonneByLogin($_POST ['per_login']);
         $_SESSION['personneConnectee'] = serialize($personneConnecte);
         unset($_SESSION['reponseCaptcha']);
         afficherMessageSucces("Vous avez été connecté.");
         redirection(1, ACCUEIL);
      }
  	}
}
?>
