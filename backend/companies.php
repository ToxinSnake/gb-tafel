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
  } 
  catch (Exception $e){
    $msg = $e->getMessage();
  }

  if($result == true){
    $msg = $_POST["companyInput"]." erfolgreich hinzugefügt!";
  }
  
//Abteilung hinzufügen
} else if(!empty($_POST["departmentInput"]) && !empty($_POST["companyList"])){
  try{
    $result = addDepartmentToDb($_POST["companyList"] ,$_POST["departmentInput"]);
  }
  catch (Exception $e){
    $msg = $e->getMessage();
  }

  if($result == true){
    $msg = $_POST["departmentInput"]." erfolgreich hinzugefügt!";
  } else {
    $msg = $_POST["departmentInput"]." hinzufügen gescheitert!";
  }

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
        <?php if(!empty($msg)){ ?> <p> <?php echo $msg; ?> </p> <?php } ?>
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
          <select name="delDepCompany">
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
          <input type="text" name="companyInput" placeholder="Neue Firma"  maxlength="60" autofocus required>
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
          <input type="text" name="departmentInput" placeholder="Neue Abteilung"  maxlength="60" required>
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
</body>
<script type="text/javascript">
jQuery(document).ready(function(){                
// Sobald eine FirmajQuery(document).ready(function(){                
// Sobald eine Firma ausgewählt wird
    jQuery("select[name='delDepCompany']").change(function(){                
                    
        // get the selected option value of country
        var optionValue = jQuery("select[name='delDepCompany']").val();     
                                        
        jQuery.ajax({
            type: "GET",
            url: "../app/cmp_ajaxlist.php",
            data: "delDepCompany="+optionValue,
            success: function(response){
                jQuery("#depSelector").html(response);
                //jQuery("#depSelector").show();
            }
        });             
    });
}); 
</script>

</html>
