
<div id="container">
  <div class="card text-white bg-secondary mb-3" style="">
    <div class="card-header text-primary">Avatar</div>
    <div class="card-body">
      <div class="form-group avatar">
        <label for="fname" class="col-lg-2 control-label text-info"><strong>Changer l'avatar</strong></label>
        <div class="col-lg-10">
          <div class="custom-file">
            <ul>
              <li>
                <button type="button" onclick="browseClicked()" class="btn btn-secondary">
                  Parcourir
                </button>
              </li>
              <li>
                <div class="browse">
                  <ul class="browse-pics">
                    <?php
                    $handle = opendir('images/avatar/');
                    $allows = array('gif','jpg','jpeg','png','svg');

                    while($file = readdir($handle)){
                    $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                    if($file !== '.' && $file !== '..' && in_array($ext, $allows)){
                           $canAdd = ($context->getSessionAttribute('avatar') == $context->getSessionAttribute('url').'images/avatar/'.$file)?1:0;
                          echo '<li style="color: black;" class="avatar-item '.($canAdd?'selected':'').'" onclick="selectedAvatarItem(this)"><div class="avatar-item-pic"><img src="images/avatar/'.$file.'" width="50px" height="50px" /></div><div class="avatar-itme-name">'.$file.'</div></li>';
                        }
                    }
                    ?>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </div>
        <div class="preview" style="text-align:center;">
          <ul>
            <li class="pic-txt">
              <label class="text-info"><strong>Prévisualisation</strong></label>
            </li>
            <li class="pic">
              <img id="avatarPreview" width="200px" height="200px" src="<?php echo $context->getSessionAttribute('avatar')==""?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg":$context->getSessionAttribute('avatar');?>" alt="ton avatar" />
            </li>
          </ul>
        </div>
      </div>
      <div class="form-group">
        <div class="col-lg-10 col-lg-offset-2 connec-btn">
        <a id="avatarUpdate" href="?action=updateAvatar&pic=NULL"> <button type="button" class="btn btn-primary">Mettre à jour</button></a>
          <a href="?action=changeInfo"> <button type="button" class="btn btn-primary">Annuler</button></a>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

function selectedAvatarItem(item){
  if(!item.classList.contains('selected'))
  {
    let selected = document.querySelector('.selected')
    if(selected!=null)
      selected.classList.remove('selected')
    item.classList.add('selected')

    document.querySelector('#avatarPreview').setAttribute('src','images/avatar/'+item.children[1].textContent)
    document.querySelector('#avatarUpdate').setAttribute('href','?action=updateAvatar&pic='+document.querySelector('#avatarPreview').getAttribute('src'))
  }

}
function browseClicked(){
  let br = document.querySelector('.browse')
  let pr = document.querySelector('.preview')

  if(br.classList.contains('active')){
    $('.browse').animate({
      float: 'left',
      backgroundColor: 'white',
      width: '0px',
      height: '0px',
      opacity: '0',
    },"slow").delay( 1000 ).removeClass( "active" );
    pr.classList.remove('active')
    pr.classList.add('reverse');
    setTimeout(function () {
      pr.classList.remove('reverse')
}, 1000);

  }else{
    br.classList.add('active');
    pr.classList.add('active');
  }

}

  function readURL(input) {

    if (input.files && input.files[0]) {
      var reader = new FileReader();

      reader.onload = function(e) {
        $('#avatarPreview').attr('src', e.target.result);
      }

      reader.readAsDataURL(input.files[0]);
    }
  }

  $("#newAvatar").change(function() {
    readURL(this);
  });

  switchNav('.account')
</script>
