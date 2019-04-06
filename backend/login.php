<?php
session_start();
require_once "../app/auth.php";

if(isset($_SESSION["username"])){
  header("Location: index.php"); 
  exit;
}

if(isset($_SESSION["referer"])){
  $msg = "Bitte loggen Sie sich ein!";
}

if(isset($_POST["username"]) && isset($_POST["password"])){
  if(validateLogin($_POST["username"], $_POST["password"])){    
    $_SESSION["username"] = $_POST["username"];
    setPrivilege($_POST["username"]);
    if(isset($_SESSION["referer"])){
      header("Location: ".$_SESSION["referer"]); 
      exit;
    } else {
      header("Location: index.php"); 
      exit;
    }
  } else {
    $msg = "Benutzername oder Passwort ungültig!";
  }
}
?>
<!DOCTYPE html>
<!--
* Made by Arne Otten
* www.mj-12.net
* 22/03/2019
-->
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
      <div class="twelve columns" id="menu">
        <h3>Anmelden</h3>
        <?php if(!empty($msg)){ ?> <p class="response"> <?php echo $msg; ?> </p> <?php } ?>
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
