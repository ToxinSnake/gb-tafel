<?php
require_once "./app/doorsign_methods.php";
try{
  $rooms = getRoomIds();
}
catch(Exception $e){
  $msg = $e->getMessage();
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
  <title>Raumauswahl</title>
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
  <link rel="stylesheet" href="css/normalize.css">
  <link rel="stylesheet" href="css/skeleton.css">
  <link rel="stylesheet" href="css/menustyle.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns" id="menu">
        <h3>Raumauswahl</h3>
        <?php foreach($rooms as $room) { ?>
        <a class="button button-primary" href="doorsign.php?id=<?php echo $room['RId']; ?>"><?php echo $room["Roomname"]; ?></a>
        <?php } ?>
        <a class="button button" href="backend/login.php">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
