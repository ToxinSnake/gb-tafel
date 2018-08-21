<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 08/07/2018
-->

<?php
include "../app/change_methods.php";

$msg = NULL;

if(!empty($_POST["edit"])){
  $resultset = getPerson($_POST["edit"]);
  $row = $resultset->fetch(); //getPerson should always return only one row so we just fetch

} else {
  $msg = "Keine PNr ausgewählt!";
}

 ?>

<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Geburtstag ändern</title>
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
        <h3>Geburtstag ändern</h3>
      <?php if(!empty($msg)){ ?> <p> <?php echo $msg; ?> </p> <?php } ?>
        <form action="" method="post">
          <input type="text" name="changeFirstName" value="<?php echo isset($row["Firstname"]) ? htmlspecialchars($row['Firstname']) : ''  ?>" placeholder="Vorname"  maxlength="40" autofocus required>
          <input type="text" name="changeLastName" value="<?php echo isset($row["Lastname"]) ? htmlspecialchars($row['Lastname']) : '' ?>" placeholder="Nachname"  maxlength="40" required>
          <input type="date" name="changeBirthday" value="<?php echo isset($row["Birthday"]) ? htmlspecialchars($row['Birthday']) : '' ?>" placeholder="Geburtstag (YYYY-mm-dd)" maxlength="10" required>
          <input type="hidden" value="<?php echo ($_POST["edit"]) ?>" name="pnr">
          <input class="button-primary" value="Ändern" formaction="search.php" type="submit">
        </form>
        <a class="button button" href="search.php">Abbrechen</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
