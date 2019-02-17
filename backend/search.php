<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 08/07/2018
-->
<?php
include "../app/search_methods.php";

//delete
if(!empty($_POST["del"])){
  $resultset = delete($_POST["del"]);
}
//edit
if(!empty($_POST["pnr"]) && !empty($_POST["changeFirstName"]) && !empty($_POST["changeLastName"]) && !empty($_POST["changeBirthday"])){
  try{
    $changeResult = changeToDB($_POST["pnr"], $_POST["changeFirstName"], $_POST["changeLastName"], $_POST["changeBirthday"]);
    $msg = "Ändern erfolgreich!";
  }
  catch(Exception $e){
    $msg = $e->getMessage();
  }
}

//default behaviour
if(empty($_GET)){
  $resultset = showDefault();
}

//search
else {
  try{
    $resultset = search($_GET["firstNameInput"], $_GET["lastNameInput"], $_GET["birthdayInput"]);
  }
  catch(Exception $e){
    $msg = $e->getMessage();
  }
}



?>


<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Geburtstag suchen</title>
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
  <script type="text/javascript" src="../js/jquery.tablesorter.min.js"></script>


  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <h3>Geburtstag suchen</h3>       
      <form action="" method="get">
        <div class="four columns" >
          <input name="firstNameInput" placeholder="Vorname" type="text" autofocus>
        </div>
        <div class="four columns" > 
          <input name="lastNameInput" placeholder="Nachname" type="text">
        </div> 
        <div class="four columns" >
          <input name="birthdayInput" placeholder="Geburtstag (YYYY-mm-dd)" type="text">
        </div>
        <div class="twelve columns" style="text-align: center"> 
          <input class="button-primary" value="Suchen" type="submit">
        </div>
      </form>
      <div class="twelve columns" style="text-align: center">
        <a class="button button" href="edit.html">Zurück</a>
      </div>
      <br>
    </div>

    <?php
    //Messages get displayed here
    if(!empty($msg)){
      echo $msg;
    }
    ?>
    <div class="row"> 
      <div class="twelve columns">
        <table id="resultTable" class="u-full-width" style="table-layout: fixed">
          <thead>
            <tr>
              <th class="head">Vorname</th>
              <th class="head">Nachname</th>
              <th class="head">Firma</th>
              <th class="head">Abteilung</th>
              <th class="head">Geburtstag</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <?php
            //iterate over PDOStatement if connection to db is established
            if($resultset instanceof PDOStatement){
              foreach ($resultset as $row){ ?>
              <tr>
                <td><?php echo $row['Firstname'];?></td>
                <td><?php echo $row['Lastname'];?></td>
                <td></td>
                <td></td>
                <td><?php echo $row['Birthday'];?></td>
                <td><form action="" method="post">
                  <!--<button class="del" style="font-size: 9px;" name="del" type="submit" onclick="return confirm('Wirklich löschen?');" value="<?php echo $row['PNr'];?>">Löschen</button>-->
                  <a class="del" id="delete" onclick="deleteEntry(<?php echo $row['PNr'];?>)"><img class="icon-btn" src="../images/delete.png"></a>
                  <!--<button style="font-size: 9px;" name="edit" type="submit" formaction="change.php" value="<?php echo $row['PNr'];?>">Ändern</button>-->
                  <a class="edit" id="edit" onclick="editEntry(<?php echo $row['PNr'];?>)"><img class="icon-btn" src="../images/edit.png"></a>
                </form></td>
              </tr>
        <?php }
            } ?>
          </tbody>
    </div>
  </div>
</div>

<!-- Tablesorter JS -->
<script>
$(document).ready(function()
    {
      $("#resultTable").tablesorter();
    }
);
</script>
<script>
  function deleteEntry(pnr){
    alert("Du willst "+pnr+" löschen!");
  }

  function editEntry(pnr){
    alert("Du willst "+pnr+" bearbeiten!");
  }
</script>

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
