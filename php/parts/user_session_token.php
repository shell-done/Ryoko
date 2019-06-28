<?php
// \file user_session_token.php
// Permet l'ajout du token utilisateur dans la js de la page
?>

<?php $user = unserialize($_SESSION["user"]); ?>

<script>
  const userToken = '<?php echo $user->getToken(); ?>';
</script>
