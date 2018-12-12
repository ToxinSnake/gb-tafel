<?php

function connect(){
  $configs = include('config.php');
  $path = $configs['PATH_TO_SQLITE_FILE'];

  if(file_exists($path)){
    try{
      $dbh = new PDO("sqlite:".$path);
      return $dbh;
    } //endtry
    catch (PDOException $e){
      return CONNECTION_FAILED;
    } //endcatch
  }
  else {
    return DB_DOES_NOT_EXISTS;
  } //endelse
}

/*
* Returns resultset of birthdays sorted by date. Birthdays of today are always at the top.
*/
function getCurrentAndUpcoming(){
  $pdo = connect();
  if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zu DB fehlgeschlagen!");
  }

  $sql = "SELECT Firstname, Lastname, Birthday
  FROM Person
  ORDER BY (CASE WHEN strftime('%m-%d', Birthday) >= strftime('%m-%d',date('now'))
  		      THEN 0 ELSE 1
  		      END),
  strftime('%m-%d', Birthday)
  LIMIT 8;";

  return $pdo->query($sql);

}

$trans = array(
    'Monday'    => 'Montag',
    'Tuesday'   => 'Dienstag',
    'Wednesday' => 'Mittwoch',
    'Thursday'  => 'Donnerstag',
    'Friday'    => 'Freitag',
    'Saturday'  => 'Samstag',
    'Sunday'    => 'Sonntag');

 ?>
