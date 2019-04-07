<?php
session_start();
if(!isset($_SESSION["username"])){
  $_SESSION["referer"] = $_SERVER["PHP_SELF"];
  header("Location: login.php"); 
  exit;
}

//Nur Admins bekommen Zugang
if($_SESSION["privilege"] != "admin"){ 
  header('HTTP/1.0 403 Forbidden');
  exit('Forbidden');
}

include "../app/settings_methods.php";

//Verbindung testen
$result = "Hier stehen Testergebnisse.";

if(isset($_GET["testcon"])){
  $result = testConnection();
}

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
  <title>Einstellungen</title>
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
        <h3>Einstellungen</h3>
        <p><?php echo $result;?></p><br>
        <a class="button button-primary" href="?testcon">DB-Verbindung testen</a>
        <a class="button button-primary" href="?createdb">DB neu anlegen</a>
        <a class="button button" href="index.php" style="margin-top: 3em;">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
