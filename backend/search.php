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
  if(!empty($_GET["firstNameInput"]) || !empty($_GET["lastNameInput"]) || !empty($_GET["birthdayInput"])){
    try{
      $resultset = search($_GET["firstNameInput"], $_GET["lastNameInput"], $_GET["birthdayInput"]);
    }
    catch(Exception $e){
      $msg = $e->getMessage();
    }
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

  <!-- Tablesorter JS
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <script type="text/javascript" src="../js/jquery-latest.js"></script>
  <script type="text/javascript" src="../js/jquery.tablesorter.js"></script>


  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns" id="search">
        <h3>Geburtstag suchen</h3>
        <form action="" method="get">
          <input name="firstNameInput" placeholder="Vorname" type="text" autofocus>
          <input name="lastNameInput" placeholder="Nachname" type="text">
          <input name="birthdayInput" placeholder="Geburtstag (YYYY-mm-dd)" type="text">
          <input class="button-primary" value="Suchen" type="submit">
        </form>
        <a class="button button" href="edit.html">Zurück</a>
        <br>


        <?php
        //check wether connection to db established
        if($resultset instanceof PDOStatement == FALSE || !empty($changeResult)){
          echo $msg;
        }
          ?>

        <table id="resultTable" class="u-full-width" style="table-layout: fixed">
          <thead>
            <tr>
              <th class="head">Vorname</th>
              <th class="head">Nachname</th>
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
                <td><?php echo $row['Birthday'];?></td>
                <td><form action="" method="post">
                  <button style="font-size: 9px;" name="del" type="submit" onclick="return confirm('Wirklich löschen?');" value="<?php echo $row['PNr'];?>">Löschen</button>
                  <button style="font-size: 9px;" name="edit" type="submit" formaction="change.php" value="<?php echo $row['PNr'];?>">Ändern</button>
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

<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
