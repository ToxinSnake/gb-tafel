<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 26/02/2019
-->

<?php


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
        <h3>Firmen/Abteilungen verwalten</h3>
      <?php if(!empty($msg)){ ?> <p> <?php echo $msg; ?> </p> <?php } ?>
        <form action="" method="post">
          <input type="text" name="companyInput" placeholder="Neue Firma"  maxlength="60" autofocus required>
          <input class="button-primary" value="Hinzufügen" type="submit">
        </form>
        <br>
        <form action="" method="get">
        <select name="companyList">
          <option value="Trauco">Trauco</option>
          <option value="Nowebau">Nowebau</option>
        </select>
          <input type="text" name="departmentInput" placeholder="Neue Abteilung"  maxlength="60" required>
          <input class="button-primary" value="Hinzufügen" type="submit">
        </form>
        <a class="button button" href="menu.html">Zurück</a>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
