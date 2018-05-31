<div id="container">
  <div class="card text-white bg-secondary mb-3" style="">
    <div class="card-header text-primary">Informations</div>
    <div class="card-body">
      <form class="form-horizontal" action="?action=updatedInfo" method="POST">
        <fieldset>
          <div class="form-group">
            <label for="pseudo" class="col-lg-2 control-label text-info"><strong>Identifiant</strong></label>
            <div class="col-lg-10">
              <div class="input-group mb-2 mr-sm-2">
                <div class="input-group-prepend">
                  <div class="input-group-text">@</div>
                </div>
                <input class="form-control" name="identifiant" id="pseudo" value="<?php echo $context->getSessionAttribute('id');?>" type="text" required>
              </div>
            </div>
          </div>
          <div class="form-group">
            <label class="col-lg-2 control-label text-info"><strong>Mot de passe</strong></label>
            <div class="col-lg-10">
              <a href="?action=changePass"><button type="button" class="btn btn-secondary" name="update-mdp">Changer le mot de passe</button></a>
            </div>
          </div>
          <div class="form-group">
            <label for="fname" class="col-lg-2 control-label text-info"><strong>Prénom</strong></label>
            <div class="col-lg-10">
              <input class="form-control" name="fname" id="fname" value="<?php echo $context->getSessionAttribute('fname');?>" type="text" required>
            </div>
          </div>
          <div class="form-group">
            <label for="lname" class="col-lg-2 control-label text-info"><strong>Nom</strong></label>
            <div class="col-lg-10">
              <input class="form-control" name="lname" id="lname" value="<?php echo $context->getSessionAttribute('lname');?>" type="text" required>
            </div>
          </div>
          <div class="form-group">
            <label for="avatar" class="col-lg-2 control-label text-info"><strong>Avatar</strong></label>
            <div class="col-lg-10">
              <img id="avatar" width="50px" src="<?php echo $context->getSessionAttribute('avatar')==""?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg":$context->getSessionAttribute('avatar');?>" />
                <a href="?action=changeAvatar">  <button type="button" class="btn btn-secondary" name="update-mdp">Changer l'avatar</button></a>

            </div>
          </div>
          <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2 connec-btn">
              <button type="submit" class="btn btn-primary">Mettre à jour</button>
            <a href="?action=showAccount&id=<?php echo $context->getSessionAttribute('num');?>">  <button type="button" class="btn btn-primary">Annuler</button></a>
            </div>
          </div>
        </fieldset>
      </form>
    </div>
  </div>
</div>

<script type="text/javascript">
  switchNav('.account')
</script>
