<?php 
include "./app/doorsign_methods.php";

if(isset($_GET["id"])){
  $room = getRoom($_GET["id"]);
  $roomname = $room["Roomname"];
  $line1 = $room["Line1"];
  $line2 = $room["Line2"];
  $occupied = $room["Occupied"];
} else {
  $roomname = "Roomname - Call with proper Room ID";
  $line1 = "";
  $line2 = "";
  header("Location: select.php"); 
  exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($roomname); ?></title>
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
  <link rel="stylesheet" href="css/signstyle.css">

  <!-- JS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/javascript" src="js/jquery-3.3.1.js"></script>

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="line" style="<?php if(isset($_GET["id"])) echo ($occupied) ? "background-color: darkred;" : "background-color: green;";?>">
    <h1><b id="roomname" ><?php echo htmlspecialchars($roomname); if(isset($_GET["id"])) echo ($occupied) ? " - Belegt" : " - Frei"; ?></b></h1>       
    <input id="constRoomname" type="hidden" value="<?php echo htmlspecialchars($roomname); ?>">
  </div>

  <div class="container">
    <div class="row">
      <div class="twelve columns">
        <div class="status" >
          <h2><?php echo htmlspecialchars($line1); ?></h2>
          <h2><?php echo htmlspecialchars($line2); ?></h2>
        </div>
      </div>
    </div>
  </div>

  <div class="logos">
    <img src="images/trauco.png">
    <img src="images/nowebau.png">
  </div>

  <div class="switch">
    <button onclick="change()" id="switch" class="button-primary" style="<?php if(isset($_GET["id"])) echo ($occupied) ? "background-color: darkred;border-color: darkred;" : "background-color: green;border-color: green;";?>">
    <?php if(isset($_GET["id"])) echo ($occupied) ? "Belegt" : "Frei"; else echo "Free/Occupied"?>
    </button>
  </div>
<script>
  
  const roomname = $("#constRoomname").val();

  function change(){
    var status = $(".line").css("background-color");

    //"rgb(139, 0, 0)" means darkred/occupied
    if(status === "rgb(139, 0, 0)"){
      $(".line").css("background-color", "green");
      $("#switch").css("background-color", "green");
      $("#switch").css("border-color", "green");
      $("#roomname").html(roomname + " - Frei");
      $("#switch").html("Frei");

    //rgb(0, 128, 0) means green/free
    } else if (status === "rgb(0, 128, 0)"){
      $(".line").css("background-color", "darkred");
      $("#switch").css("background-color", "darkred");
      $("#switch").css("border-color", "darkred");
      $("#roomname").html(roomname + " - Belegt");
      $("#switch").html("Belegt");
    }
  }

</script>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
