<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 22/03/2019
-->

<?php
require_once "../app/auth.php";

$pdo = (new SQLiteConnection())->connect();
if(!($pdo instanceof PDO)){
  throw new Exception("Verbindung zu DB fehlgeschlagen!");
}

if(!empty($_POST["username"]) && !empty($_POST["password"])){
  if(validateLogin($_POST["username"], $_POST["password"])){
    session_start();
    $_SESSION["privilige"] = "admin";
  } 
}


?>

<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Anmelden</title>
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
      <div class="twelve column" id="menu">
        <h3>Anmelden</h3>
        <form method="POST" action="login.php">
          <input type="text" placeholder="Benutzername" name="username">
          <input type="password" placeholder="Passwort" name="password">
          <input class="button-primary" type="submit" value="Log In" style="display: block;">
        </form>
      </div>
    </div>
  </div>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
