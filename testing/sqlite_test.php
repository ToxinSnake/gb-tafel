<!--
Made by Arne Otten
www.mj-12.net
02/07/2018
-->

<!DOCTYPE html>
<html lang="en">
<head>

  <!-- Basic Page Needs
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <meta charset="utf-8">
  <title>Tafel</title>
  <meta name="description" content="">
  <meta name="author" content="">

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
  <link rel="stylesheet" href="css/gbstyle.css">

  <!-- Favicon
  –––––––––––––––––––––––––––––––––––––––––––––––––– -->
  <link rel="icon" type="image/png" href="images/favicon.png">

</head>

<?php
$db = new SQLite3('test.db');
if(!$db){
  echo $db->lastErrorMsg();
} else {
  //echo "Erfolg.\n";
}

/*
$rt = $db->exec('CREATE TABLE Person (
  PNr INTEGER PRIMARY KEY,
  Birthday TEXT NOT NULL,
  Name TEXT NOT NULL,
  Vorname TEXT NOT NULL)');

if($rt){
  echo nl2br("CREATE TABLE erfolgreich!\n");
} else {
  echo "Fehler bei CREATE.";
}
*/

/*
$rt = $db->exec("INSERT INTO Person (Name, Vorname, Birthday) VALUES ('Otten', 'Arne', datetime('now'))");

if($rt){
  echo nl2br("INSERT INTO erfolgreich!\n");
} else {
  echo "Fehler bei INSERT.";
}
*/

$result = $db->query('SELECT * FROM Person');
 ?>

<body>
<div class="container">
  <table class="u-full-width">
    <thead>
      <tr>
        <th><?php echo $result->columnName(0); ?></th>
        <th><?php echo $result->columnName(1); ?></th>
        <th><?php echo $result->columnName(2); ?></th>
        <th><?php echo $result->columnName(3); ?></th>
      </tr>
    </thead>
    <tbody>

    <?php
    while($res = $result->fetchArray(SQLITE3_ASSOC)){
      if(!isset($res['PNr'])) continue;
    ?>
    <tr>
      <td><?php echo $res['PNr'];?></td>
      <td><?php echo $res['Birthday'];?></td>
      <td><?php echo $res['Name'];?></td>
      <td><?php echo $res['Vorname'];?></td>
    </tr>
    <?php
    }
    ?>
  </tbody>
</div>

</body>
