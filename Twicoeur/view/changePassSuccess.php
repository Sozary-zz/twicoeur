<div id="container">
  <div class="card text-white bg-secondary mb-3" style="">
    <div class="card-header text-primary">Mot de passe</div>
    <div class="card-body">
      <form class="form-horizontal" action="?action=updatedPass" method="POST">
        <fieldset>
          <div class="form-group">
            <label for="current-pass" class="col-lg-4 control-label text-info"><strong>Mot de passe actuel</strong></label>
            <div class="col-lg-10">
              <input class="form-control" name="current-pass" id="current-pass" type="password" required>
            </div>
          </div>
          <div class="form-group">
            <label for="new-pass-1" class="col-lg-4 control-label text-info"><strong>Nouveau mot de passe</strong></label>
            <div class="col-lg-10">
              <input class="form-control" name="new-pass-1" id="new-pass-1" type="password" required>
            </div>
          </div>
          <div class="form-group">
            <label for="new-pass-2" class="col-lg-4 control-label text-info"><strong>Vérification nouveau mot de passe</strong></label>
            <div class="col-lg-10">
              <input class="form-control" name="new-pass-2" id="new-pass-2" type="password" required>
              <div class="invalid-feedback">
                Mots de passe différents!
              </div>
            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2 connec-btn">
              <button type="submit" class="btn btn-primary">Mettre à jour</button>
              <a href="?action=changeInfo"> <button type="button" class="btn btn-primary">Annuler</button></a>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  $('form').on('submit', function() {
    if ($('#new-pass-1').val() != $('#new-pass-2').val()) {
      document.querySelector('.invalid-feedback').style.display = "block";
      document.querySelector('#new-pass-2').style.borderColor = "#F04124";
      document.querySelector('#new-pass-2').style.boxShadow = "0 0 0 0.2rem rgba(240, 65, 36, 0.25)";
      return false;
    } else {
      return true;
    }


  });
  switchNav('.account')
</script>
