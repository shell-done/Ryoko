<?php
  require_once("../php/parts/head.php");
?>

<html>
  <?php generateHead(["index-admin", "admin-navbar", "add-country", "navbar"]);?>

  <body>
    <?php require("parts/navbar_admin.html"); ?>
    <?php require("parts/navbar.html"); ?>
    <?php require("parts/add-country-banner.html"); ?>
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
  </body>
</html>
