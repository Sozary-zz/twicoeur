<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://bootswatch.com/4/yeti/bootstrap.min.css">
  <link rel="stylesheet" href="css/profile-style.css">
  <link rel="stylesheet" href="css/layout-style.css">
  <link rel="stylesheet" href="css/avatar-style.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://bootswatch.com/_vendor/jquery/dist/jquery.min.js"></script>
  <script src="js/tools.js"></script>
  <script src="js/global-script.js"></script>
  <script src="js/inf.js"></script>
  <title>Twicoeur</title>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <a class="navbar-brand" href="#">Twicoeur</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor01" aria-controls="navbarColor01" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

    <div class="collapse navbar-collapse" id="navbarColor01">
      <ul class="navbar-nav mr-auto">
        <?php
      if(!empty($context->getSessionAttribute('id'))) :?>
          <li class="flux">
            <a class="nav-link" href="?action=flux">Flux</a>
          </li>
          <li class="account">
            <a class="nav-link" href="?action=account">Compte</a>
          </li>
          <li class="disconnect">
            <a class="nav-link" href="?action=disconnect">Déconnexion</a>
          </li>
          <li class="disconnect">
            <a class="nav-link" href="?action=helloWorld">Hello World</a>
          </li>
          <?php else:?>
          <li class="connection">
            <a class="nav-link" href="?action=welcome">Connexion</a>
          </li>
          <li class="register">
            <a class="nav-link" href="#">Inscription</a>
          </li>
          <?php endif;?>
      </ul>
      <?php if(!empty($context->getSessionAttribute('id'))) :?>
      <form class="form-inline my-2 my-lg-0">
        <button type="button" class="btn btn-secondary my-2 my-sm-0" onclick="modalNewTwic()">
          Twic
        </button>
      </form>
      <?php endif;?>
    </div>
  </nav>
  <div class="modal fade" id="newTwic" role="dialog">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Composer un nouveau Twic (avec amour!)      </h5>
          <div class="loading-found new-twic-loader"></div>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        </div>
        <div class="modal-body new-twic-body">
          <img class="new-twic-ico" src="<?php echo empty($context->getSessionAttribute('avatar'))?" images/svg/user.svg ":$context->getSessionAttribute('avatar');?>" />
          <textarea class="new-twic-textarea" maxlength="140" name="twic-content" placeholder="Express yourself!" rows="8" cols="40"></textarea>
          <div class="new-twic-progress-container"></div>
          <div class="new-twic-pic"> <img class="new-twic-pic-content" src="" alt="" width="100px" height="100px"> </div>
          <button type="button" class="new-twic-browse" onclick="newBrowse()">Imagez votre twic!</button>
          <button type="button" onclick="newTwic(<?php echo ($context->num == $context->getSessionAttribute('num'))?" true ":"false ";?>)" class="new-twic-send">Twic</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="browse-twic" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Choisir une image pour son twic (encore et toujours avec amour!)</h4>
          <button type="button" class="close" onclick="clearBrowse()" data-dismiss="modal">&times;</button>

        </div>
        <div class="modal-body new-twic-body">

          <ul class="browse-pics">
            <?php
              $handle = opendir('images/avatar/');
              $allows = array('gif','jpg','jpeg','png','svg');

              while($file = readdir($handle)){
              $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
              if($file !== '.' && $file !== '..' && in_array($ext, $allows))
                    echo '<li style="color: black;" class="avatar-item" onclick="selectedItem(this)"><div class="avatar-item-pic"><img src="images/avatar/'.$file.'" width="50px" height="50px" /></div><div class="avatar-itme-name">'.$file.'</div></li>';
              }
              ?>
          </ul>

          <div class="next-browse-new-twic-calc">  </div>
          <div class="next-browse-new-twic" onclick="clickNext()"> <div class="next-browse-arrow">


          </div> </div>


        </div>
      </div>
    </div>
  </div>

  <?php if(!empty($context->msg)) :?>
  <div class=" <?php echo $context->msg[0]?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <strong><?php echo $context->msg[1]?></strong>
    <?php echo $context->msg[2]?>
  </div>
  <?php endif; ?>
  <?php include($template_view); ?>
  <script src="js/layout-script.js"></script>
  <script src="https://bootswatch.com/_vendor/popper.js/dist/umd/popper.min.js"></script>
  <script src="https://bootswatch.com/_vendor/bootstrap/dist/js/bootstrap.min.js"></script>
  <script src="https://bootswatch.com/_assets/js/custom.js"></script>
  <script type="text/javascript">
  function selectedItem(item){
    if(!item.classList.contains('selected'))
    {
      let selected = document.querySelector('.selected')
      if(selected!=null)
        selected.classList.remove('selected')
      item.classList.add('selected')
      document.querySelector('.new-twic-pic-content').setAttribute('src','images/avatar/'+item.children[1].textContent)
    }

  }

  let clearBrowse = ()=>{
document.querySelector('.browse-pics .selected').classList.remove('selected')
    document.querySelector('.new-twic-pic-content').setAttribute('src','')

  }
  let isInElem=(elem, x,y)=>{
    let obj = elem.getBoundingClientRect()
    if(x>=obj.left && x<=obj.left+obj.width)
      if(y>=obj.top && y<=obj.top+obj.height)
        return true
      return false

  }
  var calc = document.querySelector('.next-browse-new-twic-calc')
  var next = document.querySelector('.next-browse-new-twic')

  let clickNext = (item)=>{
    if(next.classList.contains('active')){
      $('#browse-twic').modal('hide')
    }
  }
  window.addEventListener("mousemove", function( event ) {
    if(isInElem(calc,event.clientX,event.clientY)){
      if(!next.classList.contains('active')){
          next.style.left = "92%";
          next.style.opacity = "1";
          next.style.cursor="pointer"
          next.classList.add('active')
      }
    }else{
      if(next.classList.contains('active')){
          next.style.left = "100%";
          next.style.opacity = "0";
          next.style.cursor="inherit"
          next.classList.remove('active')
      }
    }

  })

  </script>
</body>

</html>
