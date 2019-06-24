<?php
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["index", "navbar", "header", "pays", "footer"]);?>

  <body>
    <?php require("parts/navbar.html"); ?>
    <?php require("parts/header.html"); ?>

    <div class="position-relative">
        <form class="add-country-bar">
            <h2>Ajouter</h2>
            <div id="box1">
                <div class="form-elements">
                    <label for = "add-title">ISO Code</label>
                    <input type="text" id="add-title" maxlength="64">
                </div>
            </div>
            <div id="box2">
                <div class="form-elements">
                    <label for = "add-title">Pays</label>
                    <input type="text" id="add-title" maxlength="64">
                </div>
                <div class="form-elements" style="float: right;">
                    <button type="submit" id="search-button">Ajouter</button>
                </div>
            </div>
        </form>
    </div>

    <div class="container">
        <div class="results-box">
            <h2>Les pays disponibles</h2>
            <div class="container">
                <div id="id-travel-1" class="travel row">
                <table id="pays">
                    <tbody>
                        <tr>
                            <th>Country</th>
                            <th>ISO Code</th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <td>AFGHANISTAN</td>
                            <td>
                                AF
                            </td>
                            <td>
                                modifier
                            </td>
                            <td>
                                supprimer
                            </td>
                        </tr>
                        <tr>
                            <td>ALBANIA</td>
                            <td>
                                AL
                            </td>
                            <td>
                                modifier
                            </td>
                            <td>
                                supprimer
                            </td>
                        </tr>
                        <tr>
                            <td>
                                ALGERIA
                            </td>
                            <td>
                                DZ
                            </td>
                            <td>
                                modifier
                            </td>
                            <td>
                                supprimer
                            </td>
                        </tr>
                        <tr>
                            <td>
                                AMERICAN SAMOA
                            </td>
                            <td>
                                AS
                            </td>
                            <td>
                                modifier
                            </td>
                            <td>
                                supprimer
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require("parts/footer.html"); ?>
  </body>
</html>
