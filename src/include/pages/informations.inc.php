<script> changerTitre("Informations"); </script>

<h1>Informations sur ce TP</h1>

<table class="pure-table sortable">
    <thead>
        <tr>
            <th>Nombre de</th>
            <th>Valeur</th>
        </tr>
    </thead>

    <tbody>
        <tr>
            <td>Classes PHP</td>
            <td><?php echo getNbFile("classes", "class.php"); ?></td>
        </tr>

        <tr>
            <td>Formulaires</td>
            <td><?php echo getNbFile("include/pages/form", "form.inc.php"); ?></td>
        </tr>

        <tr>
          <td>Tableaux </td>
          <td><?php echo getNbFile("include/pages/tab", "tab.inc.php"); ?></td>
        </tr>

        <tr>
            <td>Feuilles de style</td>
            <td><?php echo getNbFile("css", "css"); ?></td>
        </tr>

        <tr>
            <td>Feuilles javascript</td>
            <td><?php echo getNbFile("js", "js"); ?></td>
        </tr>
    </tbody>
</table>

<div id='infos'>


<h2> Détails sur mon travail </h2>
<p>
  Ce site est un TP réalisé lors de ma deuxième année de DUT Informatique à l'IUT du Limousin.<br/>
  Vous trouverez ci-dessous quelques informations supplémentaires <br/> <br/>
  Votre adresse IP : <?php echo $_SERVER["REMOTE_ADDR"]." (port ".$_SERVER["REMOTE_PORT"].")"; ?><br/>
  Vous êtes actuellement sur le serveur  <?php echo $_SERVER["SERVER_NAME"]." (".$_SERVER["SERVER_ADDR"].":".$_SERVER["SERVER_PORT"].")"; ?>
</p>

<p>Ci-dessous, affichage du README, à l'aide de Parsedown, du dépôt <a href="https://github.com/sylvainmetayer/Betisier-TP" title="Lien vers le dépôt GitHub">GitHub</a>. </p>
<?php
  $parsedown = new Parsedown();
  $file = lireFichier(README);
  $implode = implode($file);
  echo $parsedown->text($implode);
?>


</div>

<div class="bottomDocument"></div>
