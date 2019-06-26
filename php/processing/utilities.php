<?php
  function showInfErr($info, $error) {
    if(!isset($info) && !isset($error))
      return;

    $header = "Information";
    $content = isset($error) ? $error : $info;
    $content = base64_decode($content);

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
  }
?>
