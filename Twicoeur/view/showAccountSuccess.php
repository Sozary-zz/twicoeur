<div class="headband">
  <div class="slide-account">
    <div class="slide-container">
      <ul>
        <li class="slide" style="text-align:center;">
          <div <?php if($context->num == $context->getSessionAttribute('num')):?> onclick="changeStatus()"
            <?php endif;?> class="profile-pic">
            <img src="<?php echo $context->avatar==" "?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg ":$context->avatar;?>" />
          </div>
          <div class="user-id">
            <?php echo '@'.$context->id ?>
          </div>
        </li>
        <li class="slide">
          <div class="card bg-light mb-3 user-data" style="max-width: 20rem;">
            <div class="card-header">
              <?php echo $context->fname." ".$context->lname;?>
            </div>
            <div class="card-body">
              <h4 class="card-title"><?php echo '@'.$context->id; ?></h4>
              <p class="card-text user-status">Statut:
                <?php echo htmlspecialchars($context->statut);?>
              </p>
              <div class="list-group list-group-flush">
                <?php if($context->num == $context->getSessionAttribute('num')):?>
                <div class="list-group-item">
                  <a href="?action=changeInfo">
                     <button type="button" class="btn btn-primary">Changer les infos</button>
                   </a>
                </div>
                <?php endif;?>
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
        Twics <br><span class="squeals-number"><?php echo count($context->twicsList);?></span>
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
    <?php     include('includes/displayTwic.php');  ?>
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
              <div class="hidden-id">
                <?php echo $context->allUsers[$i]->id ?>
              </div>
              <h5 class="card-title"><span class="prenom"><?php echo $context->allUsers[$i]->prenom .' '.$context->allUsers[$i]->nom;?></span></h5>
              <h6 class="card-subtitle text-muted">Statut: <span class="status"><?php echo $status==""?"Aucun":$status ; ?></span></h6>
            </div>
            <img class="following-pic" src="<?php echo $context->allUsers[$i]->avatar==" "?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg ":$context->allUsers[$i]->avatar;?>" alt="Avatar">
          </div>
        </div>
      </li>
      <?php endfor; ?>
    </ul>
  </div>
</div>
<div class="modal fade" id="updateStatus"role="dialog" >
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="width: 500px;height: 1.5em;"><div class="emo-carousel" ></div>Mis à jour du status</h5>
        <div class="loading-found update-status-loader"></div>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
      </div>
      <div class="modal-body update-status-body">
        <img class="update-status-ico" src="<?php echo empty($context->avatar)?" https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg ":$context->avatar;?>" />
        <textarea class="update-status-textarea" maxlength="100" name="status-content" placeholder="Quelle est votre humeur?" rows="8" cols="40"></textarea>
        <div class="update-status-progress-container"></div>
        <button onclick="updateStatut()" type="button" class="update-status-send">Valider</button>
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
        <a class="user-show-profil-link" href=""><button type="button" class="btn btn-primary">Profil complet</button></a>
      </div>
    </div>
  </div>
</div>
<script src="js/account-script.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip({
      html: true
    });

    <?php if($context->num == $context->getSessionAttribute('num')):?>
    switchNav('.account')
    <?php endif;?>
    switchTab('.twics')
  });
</script>
