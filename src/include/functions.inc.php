<?php

	/*Cette fonction retourne la date anglaise d'une date francaise*/
	function getEnglishDate($date){
		$membres = explode('/', $date);
		$date = $membres[2].'-'.$membres[1].'-'.$membres[0];
		return $date;
	}

	function ecrireDans($fichier, $message) {
		$file = fopen($fichier, "a");
		fwrite($file,$message);
		fclose($file);
	}

	/*Retire le javascript d'une phrase*/
	function removeJavascript($string) {
		return preg_replace('@<script[^>]*?>.*?</script>@si', '', $string);
	}

	/*
  Cette fonction permet de savoir si un numero de telephone contient bien 10 chiffres
  */
  function isCorrectNumeroDeTelephone($tel) {
      if (!is_numeric($tel))
        return false;
      return strlen($tel) === 10;
  }

	/*Cette fonction permet de vérifier le format d'un email*/
	function isCorrectEmail($email) {
		if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
			return false;
		}
		return true;
	}
	/*
  Cette fonction permet de savoir si le paramètre est bien un nombre
  */
  function isCorrectEntier($valeur) {
    if (!is_numeric($valeur)) {
      return false;
    }
    return true;
  }

	function isComprisEntre($min, $max, $valeur) {
		if ($valeur < $min) {
			return false;
		}

		if ($valeur > $max) {
			return false;
		}

    return true;
  }

	/*
	Cette fonction permet de vérifier qu'une date n'est pas supérieure à la date du jour
	*/
	function isCorrectDate($date) {
		if (!isEnglishDate($date)) {
			if (strtotime($date) > time()) {
				return false;
			}
		} else {
			if (strtotime(getEnglishDate($date)) > time()) {
				return false;
			}
		}
		return true;
	}

	/*Cette fonction permet de savoir si la date passée en paramètre en au format anglais ou non*/
	function isEnglishDate($date) {
		$membres = explode('-', $date);
		if (isset($membres[2])) {
			return false;
		}
		return true;
	}

	/*Cette fonction retourne la date francaise d'une date anglaise.*/
	function getFrenchDate($date) {
		$membres = explode('-', $date);
		$jour = explode(" ", $membres[2]);
		$date = $jour[0].'/'.$membres[1].'/'.$membres[0];
		return $date;
	}

	/**
	 * Cette fonction permet de retirer les accents d'une chaine de caractères.
	 *
	 * @param String $str
	 * @param string $charset
	 * @return string_without_accents
	 * @source http://www.weirdog.com/blog/php/supprimer-les-accents-des-caracteres-accentues.html
	 */
	function clean_chaine($str, $charset = 'utf-8') {
		$str = htmlentities ( $str, ENT_NOQUOTES, $charset );
		$str = preg_replace ( '#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str );
		$str = preg_replace ( '#&([A-za-z]{2})(?:lig);#', '\1', $str );
		$str = preg_replace ( '#&[^;]+;#', '', $str );
		return $str;
	}

	/*Cette fonction permet d'afficher un message de succès après une opération.*/
	function afficherMessageSucces($message) {
		?>
		<p>
			<img alt="valid" src="image/valid.png"/>
			<?php echo $message; ?>
		</p>
		<?php
	}

	/*Cette fonction retourne le nombre de fichier d'une extension donnée dans un dossier donné*/
	function getNbFile($dossier, $ext) {
		$fichiers = glob("$dossier/*.$ext");
		$compteur = count($fichiers);
		return $compteur;
	}

	/*Cette fonction permet d'afficher un message d'erreur après une opération*/
	function afficherMessageErreur($message) {
		?>
		<p>
			<img alt="erreur" src="image/erreur.png"/>
			<?php echo $message; ?>
		</p>
		<?php
	}

	/*Cette fonction permet d'afficher un mot interdit. Utilisé dans ajouterCitation.inc.php*/
	function afficherMotInterdit($mot) {
		?>
		<p>
			<img alt="erreur" src="image/erreur.png"/>
			Le mot <b><?php echo $mot; ?></b> est <b>interdit</b> ! <br/>
		</p>
		<?php
	}

	/*Permet de rediriger l'utilisateur a une page donnée avec un délai donné.*/
	function redirection($delai, $destination) {
		?>
			<p>Redirection dans <?php echo $delai; ?> seconde(s).. </p>
			<META HTTP-EQUIV="Refresh" CONTENT="<?php echo $delai; ?>;URL=index.php?page=<?php echo $destination; ?>">
		<?php
	}

	/* Pour des facilités de lecture */
	function isConnected() {
		return isset($_SESSION['personneConnectee']);
	}

	/*
	Permet de récupérer l'objet Personne stocke dans la variable de session.
	Penser à controler l'existence de la variable avant !
	*/
	function getPersonneConnectee() {
		return unserialize($_SESSION["personneConnectee"]);
	}

	/*Permet de générer des items avec le style pure-css en passant le lien et le titre*/
	function genererItemsMenu($texte, $destination) {
		?>
		<li class="pure-menu-item">
			<a href="index.php?page=<?php echo $destination; ?>" class="pure-menu-link">
				<?php echo $texte; ?>
			</a>
		</li>
		<?php
	}

	function salutation() {
		$heure = intval(date('H'));

		switch ($heure) {
			case 22:
			case 23:
			case 0:
			case 1:
			case 2:
			case 3:
			case 4:
			case 5:
				return "Bonne nuit";

			case 6:
			case 7:
			case 8:
				return "Bon réveil";

			case 9:
			case 10:
			case 11:
			case 12:
				return "Bonjour";

			case 13:
			case 14:
			case 15:
			case 16:
			case 17:
			case 18:
				return "Bon après-midi";
			case 19:
			case 20:
			case 21:
				return "Bonsoir";

		}

	}


	/*Permet de générer des titre de menu avec le style pure-css en passant le lien et le titre*/
	function genererTitreMenu($texte, $srcImg) {
		?>
		<span class="pure-menu-heading">
			<img class = "icone" src="image/<?php echo $srcImg; ?>" alt="<?php echo $texte; ?>"/> <?php echo $texte; ?>
		</span>
		<?php
	}

	function isPwdStrongEnough($pwd) {
		$pdo = new Mypdo();
		$pwdManager = new PwdManager($pdo);
		$isPwdForbidden = $pwdManager->isPwdForbidden($pwd);
    return (!empty($pwd) && strlen($pwd) >= 6 && empty($isPwdForbidden));
  }

	/*Fonction qui masque les détails d'une personne a un utilisateur non connecté. */
	function maskData($data) {
		$len = strlen($data);

		if ($len < 5) {
			//On ne masque pas les infos pour 5 caractères..
			return $data;
		}

		$retour = "";

		$retour = $data[0];
		for ($i = 0; $i < $len - 3; $i++) {
			$retour.= "*";
			//On masque
		}

		for ($i = $len -3; $i < $len; $i++) {
			$retour.= $data[$i];
			//On affiche les 3 derniers caractères
		}

		return $retour;

	}

	function lireFichier($file) {
		$fichier=file($file);
		return $fichier;
	}

	/*Permet d'obtenir une phrase tirée du fichier NOM_LECTURE_FICHIER aléatoirement.*/
	function getPhraseAleatoire() {
		$fichier = file(NOM_LECTURE_FICHIER);
		$nbLigne = count($fichier);

		$rand = rand(1, $nbLigne)-1;
		foreach ($fichier as $i => $valeur) {
			if ($i === $rand) {
				$retour = $valeur;
			}
		}
		return $retour;
	}

	/*Fonction utilisée lors de la modification d'une personne, permet d'effacer les données de session enregistrees temporarirement*/
	function quitterModifierPersonne() {
		if (isset($_SESSION["per_nom"]))
			unset($_SESSION['per_nom']);
		if (isset($_SESSION["per_prenom"]))
			unset($_SESSION['per_prenom']);
		if (isset($_SESSION["per_tel"]))
			unset($_SESSION['per_tel']);
		if (isset($_SESSION["per_mail"]))
		unset($_SESSION['per_mail']);
		if (isset($_SESSION["per_login"]))
			unset($_SESSION['per_login']);
		if (isset($_SESSION["per_pwd"]))
			unset($_SESSION['per_pwd']);
		if (isset($_SESSION["categorie"]))
			unset($_SESSION['categorie']);
		if (isset($_SESSION["verif_pwd"]))
			unset($_SESSION["verif_pwd"]);
		if (isset($_SESSION["per_pwd_confirmation"]))
			unset($_SESSION["per_pwd_confirmation"]);
		if (isset($_SESSION["pwdChanged"]))
			unset($_SESSION['pwdChanged']);
	}
?>
