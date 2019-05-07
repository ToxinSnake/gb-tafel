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

$msg;

require_once "../app/csvimport.php";

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
  <title>CSV-Import</title>
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
        <h3>CSV-Import</h3>
        <p><b>ACHTUNG:</b> Die CSV-Datei muss in folgendem Format vorliegen:<br/>
        Name,Vorname,Geburtsdatum,Firma,Abteilung<br/>
        <b>Bsp:</b> Baumeister,Bob,10.10.1980,Trauco,EDV<br/>
        Geburtsdatum kann im ISO (2000-12-25) oder normalen Deutschen Format (25.12.2000) vorliegen.<br/>
        Doppelte Personeneinträge werden <b>NICHT</b> erkannt!<br/>
        Der Import sollte nur direkt nach der Installation durchgeführt werden,<br/>
        oder wenn sichergestellt ist, dass nicht dutzende doppelte Einträge entstehen.
        </p>
        <?php echo (isset($msg)) ? $msg : ""; ?>
        <form enctype="multipart/form-data" action="" method="post">
          <input class="button-primary" name="fileToUpload" type="file" accept=".csv">
          <input class="button-primary" name="submit" value="Absenden" type="submit">
        </form>
        <a class="button button" href="index.php" style="margin-top: 3em;">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
