<script>changerTitre("Contact");</script>
<h1>Contact</h1>

<?php if (empty($_POST)) {
  include("include/pages/form/contact.form.inc.php");
} else {

  if (empty($_POST['nom']) || empty($_POST["prenom"]) || empty($_POST['mail']) || empty($_POST['message']) ) {
    throw new ExceptionPerso("Votre demande de contact est incomplète, merci de recommencer", ExceptionPerso::ERR_PEBCAK);
  }

  if (!isCorrectEmail($_POST["mail"])) {
    throw new ExceptionPerso("Merci de saisir une adresse mail valide", ExceptionPerso::ERR_CONTACT);
  }

  $message = preg_replace('@<script[^>]*?>.*?</script>@si', '', $_POST["message"]);
  $nom = preg_replace('@<script[^>]*?>.*?</script>@si', '', $_POST["nom"]);
  $prenom = preg_replace('@<script[^>]*?>.*?</script>@si', '', $_POST["prenom"]);
  $sujet = preg_replace('@<script[^>]*?>.*?</script>@si', '', $_POST["sujet"]);

  $message = clean_chaine($message);
  $identite = clean_chaine($prenom)." ".clean_chaine($nom);
  $sujet = (empty($sujet)) ? "Pas de sujet précisé" : clean_chaine($_POST["sujet"]);
  $mail = $_POST['mail'];

  if (empty($nom) || empty($prenom) || empty($mail) || empty($message) ) { //après avoir nettoyé les chaines, on teste à nouveau
    throw new ExceptionPerso("Votre demande de contact est incomplète, merci de recommencer", ExceptionPerso::ERR_PEBCAK);
  }

  $date = date("d/m/Y H:i");
  $message_txt = "\n\n##Nouveau message de ".$identite." le $date.\n";
  $message_txt .= "Sujet : ".$sujet."\n\n";
  $message_txt .= "**Contenu du message :** "."\n\n".$message."\n\n";
  $message_txt .= "Adresse de réponse : [".$mail."](mailto:".$mail.")\n\n----------";

  ecrireDans(SIMUL_MAIL, $message_txt);

  afficherMessageSucces("Votre demande a été prise en compte !");
  redirection(1, ACCUEIL);
}
