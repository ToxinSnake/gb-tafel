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

require_once "../app/users_methods.php";

//Neuer Benutzer
if(isset($_POST["addUserUsername"]) && isset($_POST["addUserPassword"]) && isset($_POST["addUserPrivilege"])){
  try {
    $status = addUser($_POST["addUserUsername"], $_POST["addUserPassword"], $_POST["addUserPrivilege"]);
    if($status == TRUE){
      $msg = "{$_POST["addUserUsername"]} erfolgreich hinzugefügt!";
    } else {
      $msg = "Fehler bei hinzufügen von {$_POST["addUserUsername"]}!";
    }
  } catch (Exception $e){
    $msg = $e->getMessage();
  }
}

//Privilegien ändern
elseif(isset($_POST["privEditUser"]) && isset($_POST["privEditPriv"])){
  try {
    $status = changePrivilege($_POST["privEditUser"], $_POST["privEditPriv"]);
    if($status == TRUE){
      $msg = "{$_POST["privEditUser"]} hat nun Privileg {$_POST["privEditPriv"]}!";
    } else {
      $msg = "Fehler bei Privilegienänderung von {$_POST["privEditUser"]}!";
    }
  } catch (Exception $e){
    $msg = $e->getMessage();
  }
}

//Passwort ändern
elseif(isset($_POST["editPasswdUser"]) && isset($_POST["editPasswdPassword"])){
  try{
    $status = changePassword($_POST["editPasswdUser"], $_POST["editPasswdPassword"]);
    if($status == TRUE){
      $msg = "Passwort von {$_POST["editPasswdUser"]} erfolgreich geändert!";
    } else {
      $msg = "Fehler bei Passwortänderung von{$_POST["editPasswdUser"]}!";
    }
  } catch (Exception $e){
    $msg = $e->getMessage();
  }
}

//Benutzer löschen
elseif(isset($_POST["deleteUser"])){
  try {
    $status = deleteUser($_POST["deleteUser"]);
    if($status == TRUE){
      $msg = "{$_POST["deleteUser"]} erfolgreich gelöscht!";
    } else {
      $msg = "Fehler bei Löschen von {$_POST["deleteUser"]}!";
    }
  } catch (Exception $e){
    $msg = $e->getMessage();
  }
}

$allUsers = getUsers();
?>

<!DOCTYPE html>
<!--
* Made by Arne Otten
* www.mj-12.net
* 26/02/2019
-->
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Benutzer verwalten</title>
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
      
      <div class="twelve columns">
        <h3>Benutzer verwalten</h3>
        <?php if(!empty($msg)){ ?> <p class="response"> <?php echo $msg; ?> </p> <?php } ?>
      </div>

      <!-- Links -->
      <div class="six columns manage">

        <!-- Privilegien ändern -->  
        <form action="" method="post" style="margin-bottom: 5em;">
          <select name="privEditUser" required>
            <option value="">Benutzer wählen...</option>
            <?php foreach($allUsers as $user) { if($user['Username'] == "admin") continue; ?>
            <option value="<?php echo $user['Username']; ?>"><?php echo $user['Username']; ?></option>  
            <?php } ?>  
          </select>
          <select name="privEditPriv" required>
            <option value="">Privilegien wählen...</option>  
            <option value="user">user</option>
            <option value="admin">admin</option>
          </select>
          <input class="button-primary" value="Privilegien ändern" type="submit">
        </form>        
        
        <!-- Benutzer löschen -->
        <form action="" method="post" >
          <select name="deleteUser" required>
            <option value="">Benutzer löschen...</option>
            <?php $allUsers = getUsers();
            foreach($allUsers as $user) { if($user['Username'] == "admin") continue; ?>
            <option value="<?php echo $user['Username']; ?>"><?php echo $user['Username']; ?></option>  
            <?php } ?> 
          </select>
          <input class="button-primary delete" value="Benutzer löschen" type="submit">
        </form>
      </div>

      <!-- Rechts -->
      <div class="six columns manage">

        <!-- Benutzer hinzufügen -->
        <form action="" method="post">
          <input type="text" name="addUserUsername" value="" placeholder="Benutzername"  maxlength="40" autofocus required>
          <input type="password" name="addUserPassword" value="" placeholder="Passwort"  maxlength="60" required>
          <select name="addUserPrivilege" required>
            <option value="">Privilegien wählen...</option>  
            <option value="user">user</option>
            <option value="admin">admin</option>
          </select>
          <input class="button-primary" value="Benutzer hinzufügen" type="submit">
        </form>
      
        <!-- Passwort ändern -->
        <form action="" method="post" >
          <select name="editPasswdUser" required>
            <option value="">Benutzer wählen...</option>  
            <?php $allUsers = getUsers();
            foreach($allUsers as $user) { ?>
            <option value="<?php echo $user['Username']; ?>"><?php echo $user['Username']; ?></option>  
            <?php } ?> 
          </select>
          <input type="password" name="editPasswdPassword" value="" placeholder="Passwort"  maxlength="60" required>
          <input class="button-primary" value="Passwort ändern" type="submit">
        </form>
      </div>

      <div class="twelve columns">
        <a class="button button" href="index.php">Zurück</a>
      </div>

    </div>
  </div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
