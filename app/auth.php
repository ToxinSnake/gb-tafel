<?php
require_once "../app/SQLiteConnection.php";

function validateLogin($username, $password){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }

    $sql = "SELECT Password FROM User WHERE Username IS :username";
    $statement = $pdo->prepare($sql);
    $statement->execute([':username' => $username]);
    $rtValue = $statement->fetchAll();
    
    //Benutzer existiert nicht
    if(count($rtValue) == 0){
        return false;
    } 

    if(password_verify($password, $rtValue[0]["Password"])){
        return true;
    } else {
        return false;
    }

}

function setPrivilege($username){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }

    $sql = "SELECT Privilege FROM User WHERE Username IS :username;";
    $statement = $pdo->prepare($sql);
    $statement->execute([':username' => $username]);
    $privilege = $statement->fetch()['Privilege'];

    $_SESSION["privilege"] = $privilege;
}
?>