<!--
Made by Arne Otten
www.mj-12.net
04/05/2018
-->

<?php


$db = new SQLite3('test.db');
if(!$db){
  echo $db->lastErrorMsg();
} else {
  echo "Erfolg.\n";
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

$row = $result->fetchArray();
  echo nl2br("$row[0]\n");
  echo nl2br("$row[1]\n");
  echo nl2br("$row[2]\n");
  echo nl2br("$row[3]\n");

 ?>
