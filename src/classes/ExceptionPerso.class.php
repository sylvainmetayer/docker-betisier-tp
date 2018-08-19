<?php
/* Cette classe permet de gérer des exceptions de façon personnalisée, en renvoyant un message selon l'erreur levée. */
class ExceptionPerso extends Exception {

  //Gestion des erreurs
  const ERR_NUMERIC = 1;
  const ERR_DATE = 2;
  const ERR_TEL = 3;
  const ERR_DROITS = 6;
  const ERR_CRITIQUE = 7;
  const ERR_PEBCAK = 9;
  const ERR_VOTE = 11;
  const ERR_VILLE = 12;
  const ERR_URL = 13;
  const ERR_PERSONNE = 14;
  const ERR_CITATION = 15;
  const ERR_MOT = 16;
  const ERR_CONTACT = 17;

  private $throwFrom = NULL;
  private $afficherChemin = true;

  public function __construct($message, $code = 0)
  {
    $this->throwFrom = $_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME']."?".$_SERVER['QUERY_STRING'];
    parent::__construct($message, $code);
  }

  public function __toString()
  {
    $message = "Type d'erreur : ";
    switch ($this->code) {
      case self::ERR_CONTACT:
        $message .= "Erreur lors du remplissage du formulaire de contact.";
        break;
      case self::ERR_MOT:
        $message .= "Erreur lors d'une opération sur un mot interdit.";
        break;
      case self::ERR_CITATION:
        $message .= "Erreur lors d'une opération sur une citation.";
        break;
      case self::ERR_PERSONNE:
        $message .= "Erreur lors d'une opération sur une personne.";
        break;
      case self::ERR_URL:
        $message .= "Erreur lors du changement de page.";
        break;
      case self::ERR_VILLE:
        $message .= "Erreur lors d'une opération sur une ville.";
        break;
      case self::ERR_PEBCAK:
        $message .= "Vous semblez avoir fait une erreur !";
        break;
      case self::ERR_DATE:
        $message .= "Erreur lors d'une opération sur une date ";
        break;
      case self::ERR_NUMERIC:
        $message .= "Erreur lors d'une opération sur un nombre";
        break;
      case self::ERR_TEL:
        $message .= "Erreur lors d'une opération sur un num&eacute;ro de t&eacute;l&eacute;phone";
        break;
      case self::ERR_DROITS:
        $message .= "Droits insuffisants/inexistants";
        $this->afficherChemin = false;
        break;
      case self::ERR_CRITIQUE:
        $message .= "Erreur critique, merci de contacter le developpeur via le formulaire de contact.";
        break;
      case self::ERR_VOTE:
        $message .= "Erreur lors d'une opération sur un vote";
        break;
      default : $message .= "Type d'erreur inconnu ! Merci de contacter le developpeur via le formulaire de contact";
    }
    $message .= "<br/>";
    if (empty($this->message)) {
      $message .= "Cause : Inconnue.. Le problème est de mon côté, désolé !";
    } else {
      $message .= "Cause : ".$this->message;
    }
    $message .= "<br/><br/>";
    //TODO check que ça passe
    $afficherChemin = ($this->throwFrom && $this->afficherChemin);
    if (!empty($afficherChemin)) {
      $message .= "<a href='http://".$this->throwFrom."'>Réessayer ?</a><br/>";
    }

    return $message;
  }
}
?>
