<?php
  function navbar($name, $isAdminPage = false) {
    ?>

    <nav class="navbar navbar-inverse fixed-top transparent navbar-expand-lg">
      <div class="navbar-inner container">
        <a class="navbar-brand" href="#">
          <img src="img/brand.png" height="60" alt="">
        </a>
        <div class="nav navbar-nav navbar-right">
          <div class="navbar-nav">
            <a class="nav-item nav-link" href="#">Rechercher</a>
            <a class="nav-item nav-link ml-5" href="#">
              <?php echo $name; ?>
              <img src="img/user-icon.png" class="ml-2" height="50"/>
            </a>
          </div>
        </div>
      </div>
    </nav>

    <?php
  }
?>
