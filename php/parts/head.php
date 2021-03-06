<?php
// \file head.php
// Contient la fonction pour générer la balise html <head> pour chaque page

  // Ecrit la balise <head> pour les fichiers du navigateur.
  // S'occupe d'afficher le titre de la page, d'inclure les fichiers css et js de bootstrap et d'inclure le css de la page
  // \param stylesArray Un tableau contenant le nom des fichiers css à inclure. Ceux-ci doivent être dans le dossier styles/
  function generateHead($stylesArray = array()) {
    ?>

    <head>
      <title>Ryoko - Agence de voyage</title>
      <meta charset="utf-8" />

      <!-- Bootstrap 4.0 css CDN-->
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity='sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO' crossorigin='anonymous'>
      <link rel='icon' href='img/favicon.png'>

      <?php
        /* Charge tous les fichiers de style*/
        foreach($stylesArray as $style)
          echo "<link rel='stylesheet' href='styles/$style.css'>"
      ?>

      <!-- Bootstrap 4.0, jQuery and Poppers scripts CDN-->
      <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous" defer></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous" defer></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous" defer></script>
    </head>

    <?php
  }

?>
