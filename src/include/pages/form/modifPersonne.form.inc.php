<?php // ATTENTION A L'APPELANT ! ?>

<form action="#" method="post" name="formulaireBasique" class="pure-form pure-form-aligned">
  <fieldset>
    <legend>Informations basiques</legend>

    <div class="pure-control-group">
      <label for="per_prenom">Pr&eacute;nom : </label>
      <input type="text" id="per_prenom" name="per_prenom" value="<?php echo $personne->getPerPrenom(); ?>" required> <br/>
    </div>

    <div class="pure-control-group">
      <label for="per_nom">Nom : </label>
      <input type="text" name="per_nom" id="per_nom" value="<?php echo $personne->getPerNom(); ?>" required> <br/>
    </div>


    <div class="pure-control-group">
      <label for="per_tel">T&eacute;l&eacute;phone : </label>
      <input type="tel" name="per_tel" id="per_tel" placeholder="[0]xxxxxxxxx" value="<?php echo $personne->getPerTel(); ?>" required> <br/>
    </div>

    <div class="pure-control-group">
      <label for="per_mail">Mail : </label>
      <input type="email" name="per_mail" id="per_mail" placeholder="some.example@domain.fr" value="<?php echo $personne->getPerMail(); ?>" required> <br/>
    </div>
  </fieldset>

  <fieldset>
    <legend>Informations de connexion</legend>

    <div class="pure-control-group">
      <label for="per_login">Login : </label>
      <input type="text" name="per_login" id="per_login" value="<?php echo $personne->getPerLogin(); ?>" required> <br/>
    </div>

    <div class="pure-control-group">
      <label for="verif_pwd">Mot de passe actuel <b>(obligatoire)</b>  </label>
      <input type="password" name="verif_pwd" id="verif_pwd" placeholder="******" required> <br/>
    </div>

    <div class="pure-control-group">
      <label for="per_pwd">Nouveau mot de passe <br/><i>facultatif, laisser vide pour garder votre mot de passe actuel</i>: </label>
      <input type="password" name="per_pwd" id="per_pwd" title="6 caract&egrave;res minimum" placeholder="******" > <br/>
    </div>

    <div class="pure-control-group">
      <label for="per_pwd_confirmation">Confirmation du nouveau mot de passe <br/><i>Ne pas remplir si vous ne changez pas votre mot de passe</i> : </label>
      <input type="password" name="per_pwd_confirmation" id="per_pwd_confirmation" title="6 caract&egrave;res minimum" placeholder="******"> <br/>
    </div>

    <div class="pure-control-group">
      Cat&eacute;gorie :
      <?php if ($personneManager->isEtudiant($personne->getPerNum())) { ?>
		<label for="categorie-1" class="pure-radio">
			<input type="radio" name="categorie" id="categorie-1" value="etudiant" checked>
			Etudiant
		</label>
		  <label for="categorie" class="pure-radio">
			<input type="radio" id="categorie" name="categorie" value="personnel">
			Personnel
		  </label>
        <?php } else { ?>
      <label for="categorie-1" class="pure-radio">
        <input type="radio" name="categorie" id="categorie-1" value="etudiant">
        Etudiant
      </label>

      <label for="categorie" class="pure-radio">
        <input type="radio" id="categorie" name="categorie" value="personnel" checked>
        Personnel
      </label>
        <?php } ?>
      </div>
        </fieldset>
  <input type="submit" class="pure-button button-secondary" value="Valider">
</form>
  <div class="bottomDocument"></div>

  <div>
    <i>
      <b>/!\</b><br/>
      Si vous changez la catégorie de la personne, les données correspondant au salarie (numero de téléphone professionnel) <br/>
      ou à l'étudiant (citations déposées, votes, département, ..) seront <b>EFFACEES</b> lors du changement de statut, et <b>AUCUN</b> retour en arrière ne sera possible.<br/>
      NB : Il est <b>impossible</b> d'être <b>étudiant ET administrateur</b>. Vous devez vous créer <b>deux comptes distincts</b>, pour des raisons anti-abus évidentes <br/>
      (un administrateur peut valider les citations qui sont affichées publiquement, s'il avait le droit d'ajouter des citations, cela pourrait entrainer de sérieux problèmes !) <br/>
      <b>/!\</b>

    </i>
  </div>

  <div class="bottomDocument"></div>
