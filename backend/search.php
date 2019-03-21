<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 08/07/2018
-->
<?php
require_once "../app/search_methods.php";

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
    $resultset = search($_GET["firstNameInput"], $_GET["lastNameInput"], $_GET["birthdayInput"], $_GET["company"], $_GET["departmentList"]);
  }
  catch(Exception $e){
    $msg = $e->getMessage();
  }
}
//Alle Firmen für Iteration
$companyList = getCompanies();
?>


<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Geburtstage verwalten</title>
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
  <script type="text/javascript" src="../js/searchfunctions.js"></script>


  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

</head>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <h3>Geburtstage verwalten</h3>       
      <form action="" method="get">
        <div class="four columns" >
          <input name="firstNameInput" placeholder="Vorname" type="text" autofocus>
        </div>
        <div class="four columns" > 
          <input name="lastNameInput" placeholder="Nachname" type="text">
        </div> 
        <div class="four columns" >
          <input name="birthdayInput" placeholder="" type="date">
        </div>
        <div class="four columns" style="margin-left: 0">
          <select name="company" onchange="departmentChange()">
            <option value="">Firma wählen...</option>
            <?php foreach ($companyList as $company){ ?> ?>
              <option value="<?php echo $company['CName']; ?>"><?php echo $company['CName']; ?></option>
            <?php } ?>
          </select>
        </div>
        <div class="four columns" >
          <div id="depSelector">
            <select name="departmentList" id="departmentList">
              <option value="">Abteilung wählen...</option>
            </select>
          </div>
        </div>
        <div class="four columns" >
        </div>
        <div class="twelve columns" style="text-align: center"> 
          <input class="button-primary" value="Suchen" type="submit">
        </div>
      </form>
      <div class="twelve columns" style="text-align: center">
        <a class="button button" href="new.php">Neuer Geburtstag</a>
        <a class="button button" href="menu.html">Zurück</a>
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
              <tr id=<?php echo $row['PNr'];?>>
                <td><p id="fn-<?php echo $row['PNr'];?>"><?php echo $row['Firstname'];?></p><input type="text" id="edit-fn-<?php echo $row['PNr'];?>" value="<?php echo $row['Firstname'];?>"></td>
                <td><p id="ln-<?php echo $row['PNr'];?>"><?php echo $row['Lastname'];?></p><input type="text" id="edit-ln-<?php echo $row['PNr'];?>" value="<?php echo $row['Lastname'];?>"></td>
                <td><p id="cn-<?php echo $row['PNr'];?>"><?php echo $row['CName'];?></p><input type="text" id="edit-cn-<?php echo $row['PNr'];?>" value=""></td><!-- Inputs noch füllen! -->
                <td><p id="dn-<?php echo $row['PNr'];?>"><?php echo $row['DName'];?></p><input type="text" id="edit-dn-<?php echo $row['PNr'];?>" value=""></td>
                <td><p id="bd-<?php echo $row['PNr'];?>"><?php echo $row['Birthday'];?></p><input type="date" id="edit-bd-<?php echo $row['PNr'];?>" value="<?php echo $row['Birthday'];?>" max="<?php echo date('Y-m-d') ?>"></td>
                <td><form action="" method="post">
                  <a class="del" onclick="deleteEntry(<?php echo $row['PNr'];?>)"><img class="icon-btn" src="../images/delete.png"></a>
                  <a class="edit" onclick="editEntryStart(<?php echo $row['PNr'];?>)"><img class="icon-btn" src="../images/edit.png"></a>
                  <a class="save" onclick="editEntryEnd(<?php echo $row['PNr'];?>)" id="save-<?php echo $row['PNr'];?>" onclick="editEntryStart(<?php echo $row['PNr'];?>)"><img class="icon-btn" src="../images/save.png"></a>
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
