<?php
session_start();
if(!isset($_SESSION["username"])){
  $_SESSION["referer"] = $_SERVER["PHP_SELF"];
  header("Location: login.php"); 
  exit;
}

require_once "../app/signs_methods.php";

//Raum hinzufügen
if(isset($_POST["addroom"])){
  try{
    $result = addRoom($_POST["addroom"]);
  }
  catch(Exception $e){
    $msg = $e->getMessage();
  }

  if($result == true){
    $msg = "{$_POST["addroom"]} erfolgreich hinzugefügt!";
    unset($_POST);
  } else {
    $msg = "Fehler bei Hinzufügen von {$_POST["addroom"]}!";
  }
}

//Raum bearbeiten
if(isset($_POST["editroom"])){
  if(isset($_POST["occupied"])) $_POST["occupied"] = 1;
  else $_POST["occupied"] = 0; 
  try{
    $result = editRoom($_POST["editroom"], $_POST["roomname"], $_POST["line1"], $_POST["line2"], "", $_POST["occupied"]);
  }
  catch(Exception $e){
    $msg = $e->getMessage();
  }

  if($result == true){
    $msg = "{$_POST["roomname"]} erfolgreich geändert!";
  } else {
    $msg = "Fehler bei Änderung von {$_POST["roomname"]}!";
  }
}

//Raum löschen
if(isset($_POST["delroom"])){
  try{
    $name = getRoomById($_POST["delroom"]);
    $result = deleteRoom($_POST["delroom"]);
  }
  catch(Exception $e){
    $msg = $e->getMessage();
  }

  if($result == true){
    $msg = "{$name} gelöscht!";
  } else {
    $msg = "Fehler beim Löschen von {$name}!";
  }
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
  <title>Schilder bearbeiten</title>
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

  <!-- JS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/javascript" src="../js/jquery-3.3.1.js"></script>

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

<script>
  function roomChange(){
    var id = jQuery("select[name=editroom]").val();
    $.getJSON('../app/rooms_ajax.php?roomId='+id, null, function(data){
      $("#roomname").val(data.Roomname);
      $("#line1").val(data.Line1);
      $("#line2").val(data.Line2);
      //$("#line3").val(data.Line3);
      if(data.Occupied == 1) { document.getElementById("occupied").checked = true; }
      else { document.getElementById("occupied").checked = false; }
    });
  }
  $(document).ready(function(){
    roomChange()
  }
);
</script>

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns" id="editor">
        <h3>Schilder bearbeiten</h3>
        <?php if(!empty($msg)){ ?> <p> <?php echo $msg; ?> </p> <?php } ?>

        <!-- Raum ändern -->
        <form action="" method="post" style="margin-bottom: 3em;">
        <select name="editroom" onchange="roomChange()">
            <option value="">Raum wählen...</option>
            <?php 
            //Alle Räume holen
            $rooms = getRooms(); 
            foreach($rooms as $room) {?>          
              <option value="<?php echo $room['RId']; ?>" <?php echo (isset($_POST["editroom"]) && $room['RId'] == $_POST["editroom"]) ? "selected" : ""; ?>><?php echo $room['Roomname']; ?></option>
            <?php } ?>
          </select>
          <input type="text" id="roomname" name="roomname" value="" placeholder="Raumname"  maxlength="70" autofocus required>
          <input type="text" id="line1" name="line1" value="" placeholder="Reihe 1"  maxlength="70">
          <input type="text" id="line2" name="line2" value="" placeholder="Reihe 2"  maxlength="70">
          <input type="checkbox" id="occupied" name="occupied"  value="1" ><label style="display: inline;" for="publish">Belegt</label><br>
          <input class="button-primary" value="Ändern" type="submit"><br>
        </form>

        <!-- Raum hinzufügen -->
        <form action="" method="post" style="margin-bottom: 3em;">
          <input type="text" name="addroom" value="" placeholder="Raumname"  maxlength="70" required>
          <input class="button-primary" value="Raum Hinzufügen" type="submit" style="margin-top: 0px;"><br>
        </form>

        <!-- Raum löschen -->
        <form action="" method="post">
        <select name="delroom">
            <option value="">Raum wählen...</option>
            <?php 
            //Alle Räume holen
            $rooms = getRooms(); 
            foreach($rooms as $room) {?>          
              <option value="<?php echo $room['RId']; ?>"><?php echo $room['Roomname']; ?></option>
            <?php } ?>
          </select>
          <input class="button-primary delete" value="Raum Löschen" type="submit" style="margin-top: 0px;"><br>
        </form>

        <a class="button button" href="index.php">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>