<?php
  session_start();

  function showInfErr($info) {
    $arr = explode(":", $info);
    if(sizeof($arr) < 2)
      return;

    $header = $arr[0];
    $content = $arr[1];

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

    unset($_SESSION["info"]);
  }
?>
