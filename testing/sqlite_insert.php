<?php
$db = new SQLite3('test.db');
if(!$db){
  echo $db->lastErrorMsg();
} else {
  echo "Erfolgreich verbunden!";
}


$rt = $db->exec("INSERT INTO Person (Name, Vorname, Birthday) VALUES ('Flessner', 'Pia', datetime('1997-09-03 10:11:12'))");

if($rt){
  echo nl2br("INSERT INTO erfolgreich!\n");
} else {
  echo "Fehler bei INSERT.";
}
?>
