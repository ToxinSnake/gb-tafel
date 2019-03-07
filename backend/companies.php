<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 26/02/2019
-->

<?php
include "../app/companies_methods.php";

$msg = NULL;

//Firma hinzufügen
if(!empty($_POST["companyInput"])){
  try{
    $result = addCompanyToDb($_POST["companyInput"]);
    if($result == true){
      $msg = $_POST["companyInput"]." erfolgreich hinzugefügt!";
    } else {
      $msg = $_POST["companyInput"]." hinzugefügen gescheitert!";
    } 
  } 
  catch (Exception $e){
    $msg = $e->getMessage();
  }


//Abteilung hinzufügen
} else if(!empty($_POST["departmentInput"]) && !empty($_POST["companyList"])){
  try{
    $result = addDepartmentToDb($_POST["companyList"] ,$_POST["departmentInput"]);
    if($result == true){
      $msg = $_POST["departmentInput"]." erfolgreich hinzugefügt!";
    } else {
      $msg = $_POST["departmentInput"]." hinzufügen gescheitert!";
    }    
  }
  catch (Exception $e){
    $msg = $e->getMessage();
  }

//Firma löschen
} else if(!!empty($_POST["delCompany"])){

}
?>

<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Firmen/Abteilungen verwalten</title>
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
  <script type="text/javascript" src="../js/companiesfunctions.js"></script>

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
        <h3>Firmen/Abteilungen verwalten</h3>
        <?php if(!empty($msg)){ ?> <p class="response"> <?php echo $msg; ?> </p> <?php } ?>
      </div>

      <!-- Links -->
      <div class="six columns manage">
        <form action="" method="post" style="margin-bottom: 5em;">
          <select name="delCompany">
            <?php 
            $companyList = getCompanies();
            foreach ($companyList as $company){ ?>
            <option value="<?php echo $company['CName']; ?>"><?php echo $company['CName']; ?></option>
            <?php } ?>
          </select>
          <input class="button-primary delete" value="Firma löschen" type="submit">
        </form>

        <form action="" method="post">
          <select name="delDepCompany" onchange="departmentChange()">
            <?php 
            $companyList = getCompanies();
            foreach ($companyList as $company){ ?>
            <option value="<?php echo $company['CName']; ?>"><?php echo $company['CName']; ?></option>
            <?php } ?>
          </select>
          <div id="depSelector">
            <select name="delDepDepartment">
              <option value=""></option>
            </select>
          </div>
          <input class="button-primary delete" value="Abteilung löschen" type="submit">
        </form>
        
      </div>

      <!-- Rechts -->
      <div class="six columns manage">
      
        <form action="" method="post" style="margin-bottom: 5em;">
          <input type="text" name="companyInput" placeholder="Neue Firma" value="<?php echo isset($_POST["companyInput"]) ? htmlspecialchars($_POST['companyInput']) : '' ?>" maxlength="60" autofocus required>
          <input class="button-primary" value="Hinzufügen" type="submit">
        </form>

        <form action="" method="post">
          <select name="companyList">
            <?php 
            $companyList = getCompanies();
            foreach ($companyList as $company){ ?>
            <option value="<?php echo $company['CName']; ?>"><?php echo $company['CName']; ?></option>
            <?php } ?>
          </select>
          <input type="text" name="departmentInput" placeholder="Neue Abteilung" value="<?php echo isset($_POST["departmentInput"]) ? htmlspecialchars($_POST['departmentInput']) : '' ?>" maxlength="60" required>
          <input class="button-primary" value="Hinzufügen" type="submit">
        </form>
      </div>

      <div class="twelve columns">
        <a class="button button" href="menu.html">Zurück</a>
      </div>

    </div>
  </div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
<script>
$(document).ready(function() {
  departmentChange();
});
</script>
</body>
</html>
