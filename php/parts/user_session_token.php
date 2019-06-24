<?php $user = unserialize($_SESSION["user"]); ?>

<script>
  const userToken = '<?php echo $user->getToken(); ?>';
</script>
