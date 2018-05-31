<div class="headband">
  <div class="slide-account">
    <div class="slide-container">
      <ul>
        <li class="slide" style="text-align:center;">
          <div data-toggle="modal" data-target="#updateStatus" class="profile-pic">
            <img src="https://www.gravatar.com/avatar/<?php echo md5($context->getSessionAttribute('fname').$context->getSessionAttribute('lname').'@hotmail.fr');?>" />
          </div>
          <div class="user-id">
            <?php echo '@'.$context->getSessionAttribute('id') ?>
          </div>
        </li>
        <li class="slide">
          <div class="card bg-light mb-3 user-data" style="max-width: 20rem;">
            <div class="card-header">
              <?php echo $context->getSessionAttribute('fname')." ".$context->getSessionAttribute('lname');?>
            </div>
            <div class="card-body">
              <h4 class="card-title"><?php echo '@'.$context->getSessionAttribute('id'); ?></h4>
              <p class="card-text">Statut:
                <?php echo htmlspecialchars($context->getSessionAttribute('statut'));?>
              </p>
              <div class="list-group list-group-flush">
                <div class="list-group-item">Anniversaire:
                  <?php echo $context->getSessionAttribute('bday'); ?>
                </div>
                <div class="list-group-item">
                  <button type="button" class="btn btn-primary">Changer les infos</button>
                </div>

              </div>
            </div>
          </div>
        </li>
      </ul>
    </div>
    <div style="text-align:center;">
      <span class="dot" onclick="currentSlideShow(1)"></span>
      <span class="dot" onclick="currentSlideShow(2)"></span>
    </div>
  </div>
</div>
<div class="summary">
  <ul class="list">
    <li class="twics">
      <div class="twics-container">
        Twics <br><span class="squeals-number"><?php echo count($context->allTwics);?></span>
      </div>
    </li>
    <li class="following active">
      <div class="following-container">
        Following <br><span class="following-number"><?php echo count($context->allUsers);?></span>
      </div>
    </li>
  </ul>
</div>
<div class="profile">
  <div class="twics-tab">
    <ul class="list">
      <?php if(count($context->allTwics) == 0):?>
      <li>
        <div class="alert alert-dismissible alert-info">
          Aucun post.
        </div>
      </li>
      <?php endif; ?>
      <?php for ($i=0;$i<count($context->allTwics);$i++): ?>
      <?php $img = postTable::getPostById($context->allTwics[$i]->post)->image; ?>
      <li>
        <div class="twic">
          <div class="card text-white bg-info mb-3" style="max-width: 20rem;">
            <div class="card-header">
              <h5 class="card-title">  <?php echo 'Posté par @'.htmlspecialchars(utilisateurTable::getUserById($context->allTwics[$i]->parent)->identifiant); ?></h5>
              <h6 class="card-subtitle text-muted">  <?php echo 'Partagé par @'.htmlspecialchars(utilisateurTable::getUserById($context->allTwics[$i]->emetteur)->identifiant); ?></h6>
            </div>
            <?php if($img!=""): ?>
            <img style="height: 200px; width: 100%; display: block;" src="<?php echo $img; ?>">
            <?php endif; ?>
            <div class="card-body">
              <h4 class="card-title"></h4>
              <p class="card-text">
                <?php echo htmlspecialchars(postTable::getPostById($context->allTwics[$i]->post)->texte); ?>
              </p>
              <ul class="list-group list-group-flush" style="color:#222;">
                <li class="list-group-item">Date de création:
                  <?php echo postTable::getPostById($context->allTwics[$i]->post)->date;?>
                </li>
                <li class="list-group-item">Nombre de votes:
                  <?php echo $context->allTwics[$i]->nbVotes;?>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </li>
      <?php endfor; ?>
    </ul>
  </div>
  <div class="following-tab">
    <ul class="list">
      <?php for ($i=0;$i<count($context->allUsers);$i++): ?>
      <?php $status = htmlspecialchars($context->allUsers[$i]->statut) ;?>
      <li>
        <div class="follow" data-toggle="modal" data-target="#userInfo" onclick="saveUserInfo(this.children[0])">
          <div class="card border-light mb-3" style="max-width: 20rem;">
            <div class="card-header">
              <span class="id">  <?php echo "@".$context->allUsers[$i]->identifiant; ?>
      </span>

            </div>
            <div class="card-body">
              <h5 class="card-title"><span class="prenom"><?php echo $context->allUsers[$i]->prenom .' '.$context->allUsers[$i]->nom;?></span></h5>
              <h6 class="card-subtitle text-muted">Statut: <span class="status"><?php echo $status==""?"Aucun":$status ; ?></span></h6>
            </div>
            <img class="following-pic" src="https://www.gravatar.com/avatar/<?php echo md5($context->allUsers[$i]->prenom.$context->allUsers[$i]->nom.'@hotmail.fr');?>" alt="Avatar">
          </div>
        </div>
      </li>
      <?php endfor; ?>
    </ul>
  </div>
</div>
<div class="modal fade" id="updateStatus" tabindex="-1" role="dialog" aria-labelledby="updateStatusLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="width: 500px;height: 1.5em;"><div class="emo-carousel" ></div>Mis à jour du status</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body update-status-body">
        <img class="update-status-ico" src="https://www.gravatar.com/avatar/<?php echo md5($context->getSessionAttribute('fname').$context->getSessionAttribute('lname').'@hotmail.fr');?>" />
        <form action="?action=updateStatus" method="POST">
          <textarea class="update-status-textarea" maxlength="100" name="status-content" placeholder="Quelle est votre humeur?" rows="8" cols="40"></textarea>
          <div class="update-status-progress-container"></div>
          <button type="button" class="update-status-send">Valider</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
</script>
<div class="modal fade" id="userInfo">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title user-info-title"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="user-info-body"></div>
        <div class="user-info-statut"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary">Profil complet</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>
<script src="js/account-script.js"></script>
<script type="text/javascript">
  switchNav('.account')
  switchTab('.twics')
</script>