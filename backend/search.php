<!DOCTYPE html>

<!--
* Made by Arne Otten
* www.mj-12.net
* 08/07/2018
-->
<?php
include "../app/search_methods.php";
$resultset = showAll(); //PDOStatement on success, int on fail
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
  <!-- <link rel="stylesheet" href="../css/menustyle.css"> -->

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="../images/favicon.png">

</head>
<style>

h3{
  text-align: center;
  border-bottom: 1px solid #eeee;
  padding-bottom: 0.5em;
  min-width: 230px;
  max-width: 400px;
  display: block;
  margin: 1em auto;
}

input[type="text"], .button, select{
  max-width: 200px;
  min-width: 115px;
  width: 100%;
}

.twelve.columns{
  text-align: center;
}

</style>
<body>

  <!-- Primary Page Layout
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <div class="container">
    <div class="row">
      <div class="twelve columns">
        <h3>Geburtstag suchen</h3>
        <form>
          <input id="firstNameInput" placeholder="Vorname" type="text" autofocus>
          <input id="LastNameInput" placeholder="Nachname" type="text"><br>
          <input id="Birthday" placeholder="Geburtstag" type="text">
          <select>
             <option value="" disabled selected>Sortieren nach...</option>
             <option value="sortFirstnameAsc">Vorname (Aufsteigend)</option>
             <option value="sortFirstnameDesc">Vorname (Absteigend)</option>
             <option value="sortLastnameAsc">Nachname (Aufsteigend)</option>
             <option value="sortLastnameDesc">Nachname (Absteigend)</option>
             <option value="sortBirthdayAsc">Geburtstag (Aufsteigend)</option>
             <option value="sortBirthdayDesc">Geburtstag (Absteigend)</option>
          </select>

        </form>
        <a class="button button-primary" href="#">Suchen</a>
        <a class="button button" href="edit.html">Zurück</a>
        <br>


        <?php
        //check wether connection to db established
        if($resultset instanceof PDOStatement == FALSE){
          echo "Verbindung zur Datenbank fehlgeschlagen.";
        }
          ?>

        <table class="u-full-width">
          <thead>
            <tr>
              <th>Vorname</th>
              <th>Nachname</th>
              <th>Geburtstag</th>
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
              </tr>
        <?php }
            } ?>
          </tbody>
    </div>
  </div>
</div>
<!-- End Document
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
</body>
</html>
