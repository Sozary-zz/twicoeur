<div id="container">
  <div class="card text-white bg-secondary mb-3" style="">
    <div class="card-header text-primary">Connexion</div>
    <div class="card-body">
      <form class="form-horizontal" action="?action=login" method="POST">
        <fieldset>
          <div class="form-group">
            <label for="pseudo" class="col-lg-2 control-label text-info"><strong>Identifiant</strong></label>
            <div class="col-lg-10">
              <input class="form-control" name="id" id="pseudo" type="text">
            </div>
          </div>
          <div class="form-group">
            <label for="pass1" class="col-lg-2 control-label text-info"><strong>Mot de passe</strong></label>
            <div class="col-lg-10">
              <input class="form-control" name="pass" id="pass" type="password">
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2 connec-btn">
              <button type="submit" class="btn btn-primary">Se connecter</button>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
    <div class="card-footer" style="text-align:center">
      Pas de compte? <span class="text-info" style="font-weight:bold">Inscrivez vous!</span>
    </div>
  </div>
</div>

<script type="text/javascript">
  switchNav('.connection')
</script>
