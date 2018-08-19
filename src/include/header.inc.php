<?php
//include_once("classes/Mypdo.class.php");
//include_once("classes/PersonneManager.class.php");
$pdo = new Mypdo();
$personneManager = new PersonneManager($pdo);
$width=150;
$height=200;
?>

<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="description" content="TP de PHP DUT2 Informatique, Betisier de l'IUT">
  <?php
		$title = "Bienvenue sur le site du bétisier de l'IUT.";?>
		<title>
		<?php echo $title ?>
		</title>

    <link rel="stylesheet" type="text/css" href="css/stylesheet.css" />
    <link rel="stylesheet" type="text/css" href="css/pure-min.css">

    <link rel="stylesheet" href="js/jquery/jquery-ui.min.css">

    <link rel="icon" type="image/ico" href="image/favico.ico" />

    <script type="text/javascript" src="js/functions.js"></script>
    <script type="text/javascript" src="js/sorttable.js"></script>
    <script type="text/javascript" src="js/jquery/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="js/jquery/jquery-ui.min.js"></script>

</head>
	<body>
	<div id="header">
		<div id="connect">
      <?php if (!isConnected()) {
        ?>
        <div id="textConnecte"> <?php
          echo salutation()." Invité ! ||"; ?>
          <a href="index.php?page=<?php echo CONNEXION ?>">Connexion</a>
        </div>
      <?php } else {
        ?>
        <div id="textConnecte"> <?php
          echo salutation()." ". getPersonneConnectee()->getPerPrenom()." ! ||"; ?>
          <a href="index.php?page=<?php echo DECONNEXION ?>">Deconnexion</a>
        </div>
      <?php } ?>
		</div>
		<div id="entete">
			<div id="logo">
        <?php if (!isConnected()) { ?>
          <a href="index.php?page=<?php echo ACCUEIL; ?>"> <img src="image/lebetisier.gif" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="Le Betiser"/> </a>
        <?php } else if (!getPersonneConnectee()->isPerAdmin() && $personneManager->isEtudiant(getPersonneConnectee()->getPerNum())) { ?>
            <a href="index.php?page=<?php echo ACCUEIL; ?>"> <img src="image/smile.jpg" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="Le Betiser"/> </a>
        <?php } else {
          ?> <a href="index.php?page=<?php echo ACCUEIL; ?>"> <img src="image/lebetisier.gif" width="<?php echo $width; ?>" height="<?php echo $height; ?>" alt="Le Betiser"/> </a> <?php
        }?>

			</div>
			<div id="titre">
        Le bêtisier de l'IUT, partagez les meilleures perles !
			</div>
		</div>
	</div>
