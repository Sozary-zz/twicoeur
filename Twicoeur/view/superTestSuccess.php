<div class="container" id="container">
<?php if(isset($context->param1,$context->param2)):?>
  j’ai compris
  <?php echo $context->param1 ?>, super
  <?php echo $context->param2 ?>!

<?php else:?>
  <p class="text-danger">Vous n'avez pas spécifié de paramètres valides!</p>
<?php endif;?>
</div>
