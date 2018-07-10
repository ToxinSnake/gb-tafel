<?php

include "SQLiteConnection.php";

function addToDB($firstname, $lastname, $birthday){
  $pdo = (new SQLiteConnection())->connect();
  $sql = 'INSERT INTO Person (Firstname, Lastname, Birthday) VALUES (:firstname, :lastname, :birthday)';

  if($pdo instanceof PDO){
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
      ':firstname' => $firstname,
      ':lastname' => $lastname,
      ':birthday' => $birthday
    ]);

    return $rtvalue;
  }
  else {
    //TODO: was bei scheitern
  }

}

 ?>
