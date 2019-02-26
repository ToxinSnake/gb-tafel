<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 08/07/2018
-->

<?php
include "../app/new_methods.php";

$msg = NULL;

if(!empty($_POST["firstNameInput"]) && !empty($_POST["lastNameInput"]) && !empty($_POST["birthdayInput"])){
  try{
    $result = addToDB($_POST["firstNameInput"], $_POST["lastNameInput"], $_POST["birthdayInput"]);
  }
  catch(Exception $e){
    $msg = $e->getMessage();
  }

  if($result == true){
    $msg = "Hinzufügen erfolgreich!";
  }
}

 ?>

<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Geburtstag hinzufügen</title>
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
        <h3>Geburtstag hinzufügen</h3>
      <?php if(!empty($msg)){ ?> <p> <?php echo $msg; ?> </p> <?php } ?>
        <form action="" method="post">
          <input type="text" name="firstNameInput" value="<?php echo isset($_POST["firstNameInput"]) ? htmlspecialchars($_POST['firstNameInput']) : ''  ?>" placeholder="Vorname"  maxlength="40" autofocus required>
          <input type="text" name="lastNameInput" value="<?php echo isset($_POST["lastNameInput"]) ? htmlspecialchars($_POST['lastNameInput']) : '' ?>" placeholder="Nachname"  maxlength="40" required>
          <input type="date" name="birthdayInput" value="<?php echo isset($_POST["birthdayInput"]) ? htmlspecialchars($_POST['birthdayInput']) : '' ?>" placeholder="Geburtstag (YYYY-mm-dd)" maxlength="10" max="<?php echo date('Y-m-d') ?>" required>
          <input class="button-primary" value="Hinzufügen" type="submit">
        </form>
        <a class="button button" href="search.php">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
