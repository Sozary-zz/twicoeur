<div id="target">
  <?php

    $data['twic_id'] = $context->newTwicId;
    $data['votes'] = $context->newTwic->nbvotes;

    $data['parent_id']= utilisateurTable::getUserById($context->newTwic->parent)->id;
    $data['parent_pic'] = htmlspecialchars(utilisateurTable::getUserById($context->newTwic->parent)->avatar);
    $data['parent_pic']= $data['parent_pic']==""?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg":$data['parent_pic'];
    $data['parent_name'] = htmlspecialchars(utilisateurTable::getUserById($context->newTwic->parent)->identifiant);

    $data['emitter_id']= utilisateurTable::getUserById($context->newTwic->emetteur)->id;
    $data['emitter_pic']= htmlspecialchars(utilisateurTable::getUserById($context->newTwic->emetteur)->avatar);
    $data['emitter_pic']= $data['emitter_pic']==""?"https://pedago02a.univ-avignon.fr/~uapv1602171/squelette/images/avatar/user.svg":$data['emitter_pic'];
    $data['emitter_name'] = htmlspecialchars(utilisateurTable::getUserById($context->newTwic->emetteur)->identifiant);

    $data['post_pic'] = htmlspecialchars(postTable::getPostById($context->newTwic->post)->image);
    $data['post_text'] = postTable::getPostById($context->newTwic->post)->texte;
    $data['post_date'] = postTable::getPostById($context->newTwic->post)->date;

    $data['voted']= voteTable::getVoteByUserAndTweet($context->getSessionAttribute('num'),$data['twic_id']);
    $data['shared']= twicTable::alreadySharedTwic($context->getSessionAttribute('num'),$context->newTwic->post);
    $data['self_shared'] = $context->newTwic->parent == $context->getSessionAttribute('num');
  ?>
      <div class="votes <?php echo $data['votes'] == 0? '': " active ";?>">
        <span class="votes-number"><?php echo $data['votes'];?></span>

        <img src="images/svg/like.svg" width="15px" alt="vote">
      </div>
      <div class="card text-white bg-info mb-3">
        <div class="card-header">
          <h5 class="card-title">
            Posté par
            <a style="color: inherit;" href="?action=showAccount&id=<?php echo $data['parent_id']?>">
              <span data-toggle='tooltip' title='<img width="20px" src="<?php echo $data['parent_pic']?>"> <?php echo $data['parent_name'] ?>'>
                <?php echo '@'.$data['parent_name'] ?>
              </span>
            </a>
          </h5>
          <h6 class="card-subtitle text-muted">
            Partagé par
            <a style="color: inherit;" href="?action=showAccount&id=<?php echo $data['emitter_id']?>">
              <span data-toggle='tooltip' title='<img width="20px" src="<?php echo $data['emitter_pic'] ?>"> <?php echo $data['emitter_name']?>'>
                <?php echo '@'.$data['emitter_name'] ?>
              </span>
            </a>
          </h6>
        </div>

        <?php if($data['post_pic']!=""): ?>
        <img style="height: 200px; width: 100%; display: block;" src="<?php echo $data['post_pic'] ?>">
        <?php endif; ?>

        <div class="card-body">
          <p class="card-text">
            <?php echo $data['post_text'] ?>
          </p>
          <ul class="list-group list-group-flush" style="color:#222;">
            <li class="list-group-item">Date de création:
              <?php echo $data['post_date']?>
            </li>
            <li class="list-group-item more">
              <ul>
                <li class="vote-item" onclick="vote(this)" data-twic="<?php echo $data['twic_id'] ?>">
                    <span><?php echo !$data['voted']?"Vote":"Enlever le vote";?></span>
                    <img src="images/svg/<?php echo !$data['voted']?"like":"unlike";?>.svg" alt="vote">
                </li>
                <li class="share-item" <?php if($data[ 'shared']||$data[ 'self_shared']):?>style="cursor:not-allowed;"
                  <?php endif;?>>
                  <a <?php if(!$data[ 'shared'] &&!$data[ 'self_shared']):?>href="?action=shareTwic&id=<?php echo $data['twic_id']?>&lastPage=flux"<?php endif;?>>
                    <?php if(!$data['shared'] &&!$data['self_shared'])
                    echo "Partager";
                    elseif($data['shared'])
                    echo "Déjà partagé";
                    else
                    echo "Un de vos posts";
                    ?>
                    <img src="images/svg/share.svg" alt="share">
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>

</div>
