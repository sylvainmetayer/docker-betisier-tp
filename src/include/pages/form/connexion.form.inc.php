<form action="#" name="form" method="post" class="pure-form pure-form-aligned">

  <div class="pure-control-group">
    <label for='per_login'>
      Login
    </label>
    <input type="text" name="per_login" id="per_login">
  </div>

  <div class="pure-control-group">
    <label for='per_pwd'>
      Mot de passe
    </label>
    <input type="password" name="per_pwd" id="per_pwd">
  </div>

  <div class="pure-control-group">
    <label for='reponse'>
      <img	src="image/nb/<?php echo $nb1 ?>.jpg" alt='numero' />
      <img src="image/plus.png" alt='plus' />
      <img src="image/nb/<?php echo $nb2 ?>.jpg" alt='numero' />
    </label>
    <input type="text" id="reponse" name="reponse" />
  </div>

  <div class="pure-control-group">
    <input class="pure-button pure-button-primary" type="submit" value="Connexion" />
  </div>
</form>
