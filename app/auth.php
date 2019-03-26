<?php
require_once "../app/SQLiteConnection.php";

function validateLogin($username, $password){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }

    //Passwort hashen

    $sql = "SELECT Username FROM User WHERE Username IS :username AND Password IS :passwd;";
    $statement = $pdo->prepare($sql);
    $statement->execute([':username' => $username, 
        ':passwd' => $password]);
    $rtValue = $statement->fetchAll();
    

    if(count($rtValue) > 0){
        return true;
    } else {
        return false;
    }
}


?>