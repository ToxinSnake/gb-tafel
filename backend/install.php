<?php

require_once "../app/settings_methods.php";

//Verbindung testen
$result;

if(isset($_GET["createdb"])){
  $result = createdb();
}

?>
<!DOCTYPE html>
<!--
* Made by Arne Otten
* www.mj-12.net
* 08/07/2018
-->

<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Installation</title>
  <meta name="description" content="">
  <meta name="author" content="Arne Otten">

  <!-- Mobile Specific Metas
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- FONT
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link href="//fonts.googleapis.com/css?family=Raleway:400,300,600" rel="stylesheet" type="text/css">

  <!-- CSS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="stylesheet" href="../css/normalize.css">
  <link rel="stylesheet" href="../css/skeleton.css">
  <link rel="stylesheet" href="../css/menustyle.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns" id="menu">
        <h3>Installation</h3>
        <ol>
          <li>Datenbank durch klick auf 'Datenbank erstellen' anlegen.</li>
          <li>Bei erfolgreichem Anlegen auf 'Login' klicken und mit admin:admin einloggen</li>
          <li>Passwort für den Benutzer 'admin' ändern.</li>
          <li>Geburtstage per CSV importieren oder einzeln anlegen</li>
        </ol>
        <p><?php echo (isset($result)) ? $result : "";?></p><br>
        <a class="button button-primary" href="?createdb">Datenbank erstellen</a>
        <a class="button button" href="./" style="margin-top: 3em;">Login</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
