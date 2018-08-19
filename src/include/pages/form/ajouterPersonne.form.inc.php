<form action="#" method="post" name="formulaireBasique" class="pure-form pure-form-aligned">
  <fieldset>
    <legend>Informations basiques</legend>

    <div class="pure-control-group">
      <label for="per_prenom">Pr&eacute;nom : </label>
      <input type="text" id="per_prenom" name="per_prenom" required>
    </div>

    <div class="pure-control-group">
      <label for="per_nom">Nom : </label>
      <input type="text" id="per_nom" name="per_nom" required>
    </div>

    <div class="pure-control-group">
      <label for="per_tel">T&eacute;l&eacute;phone : </label>
      <input type="tel" name="per_tel" id="per_tel" placeholder="[0]xxxxxxxxx" required>
    </div>

    <div class="pure-control-group">
      <label for="per_mail">Mail : </label>
      <input type="email" name="per_mail" id="per_mail" placeholder="some.example@domain.fr" required> <br/>
    </div>

  </fieldset>

  <fieldset>
    <legend>Informations de connexion</legend>

    <div class="pure-control-group">
      <label for="per_login">Login : </label>
      <input type="text" name="per_login" id="per_login" required> <br/>
    </div>

    <div class="pure-control-group">
      <label for="per_pwd">Mot de passe : </label>
      <input type="password" name="per_pwd" id="per_pwd" title="6 caract&egrave;res minimum" placeholder="******" required> <br/>
    </div>

    <div class="pure-control-group">
      <label for="per_pwd_confirmation">Confirmation mot de passe: </label>
      <input type="password" name="per_pwd_confirmation" id="per_pwd_confirmation" title="6 caract&egrave;res minimum" placeholder="******" required> <br/>
    </div>

    <div class="pure-control-group">
        Cat&eacute;gorie

      <label for="categorie-1" class="pure-radio">
        <input type="radio" name="categorie" id="categorie-1" value="etudiant" checked>
        Etudiant
      </label>

      <label for="categorie" class="pure-radio">
        <input type="radio" id="categorie" name="categorie" value="personnel">
        Personnel
      </label>
    </div>
  </fieldset>

  <input type="submit" class="pure-button button-secondary" value="Valider">
  <input type="reset" class="pure-button button-error" value="Effacer">
  <br/><br>
</form>
