<?php
session_start();
if(!isset($_SESSION["username"])){
  $_SESSION["referer"] = $_SERVER["PHP_SELF"];
  header("Location: login.php"); 
  exit;
}

//Logout
if(isset($_GET["logout"])){
  
  //Cookie Parameter holen, Lebenszeit auf Vergangenheit setzen, damit Cookie vom Browser gelöscht wird.
  $params = session_get_cookie_params();
  setcookie(session_name(), '', time() - 42000,
    $params["path"], $params["domain"],
    $params["secure"], $params["httponly"]
  );
  session_destroy();

  header("Location: login.php"); 
  exit;
}

?>

<!DOCTYPE html>
<!--
* Made by Arne Otten
* www.mj-12.net
* 09/07/2018
-->


<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Hauptmenü</title>
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
        <h3>Hauptmenü</h3>
        <a class="button button-primary" href="search.php">Geburtstage bearbeiten</a>
        <a class="button button-primary" href="companies.php">Firmen/Abteilungen verwalten</a>
        <a class="button button-primary" href="signs.php">Räume verwalten</a>
        <a class="button button-primary" href="edit.php">Tafel ändern</a>
        <a class="button button-primary" href="../gbtafel.php">Tafel anzeigen</a>
        <?php if($_SESSION["privilege"] == "admin") {?>
        <a class="button button" href="users.php" style="margin-top: 3em;">Benutzer verwalten</a>
        <a class="button button" href="settings.php" >Einstellungen</a>
        <?php } ?>
        <a class="button button" href="index.php?logout=1" style="margin-top: 3em;">Logout</a>
        <p>Eingeloggt als: <?php echo $_SESSION["username"] ?></p>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
