<?php
// \file utilities.php
// Propose des fonctions utiles pour toutes les pages

  // Génère une popup d'information ou d'erreur
  // \param Le message à afficher sous la forme Titre:Contenu
  function showInfErr($info) {
    $arr = explode(":", $info);
    if(sizeof($arr) < 2)
      return;

    // On récupère séparemment le titre et le contenu
    $header = $arr[0];
    $content = $arr[1];

    // On affiche génère la div
    echo '
      <div id="info-modal" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">' . $header . '</h4>
              <button type="button" class="close" data-dismiss="modal" style="width: auto;">
                <span>&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ' . $content . '
            </div>
          </div>
        </div>
      </div>
    ';

    // On supprime l'information de la session
    unset($_SESSION["info"]);
  }
?>
