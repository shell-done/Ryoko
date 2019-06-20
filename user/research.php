<?php
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["index", "user-navbar", "user-research"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>

    <?php require("parts/research-banner.html"); ?>
  </body>

  <!-- Load scripts -->
  <script src="scripts/research.js" defer></script>
</html>
