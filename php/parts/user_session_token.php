<?php $user = unserialize($_SESSION["user"]); ?>

<script>
  var userToken = '<?php echo $user->getToken(); ?>';
</script>
