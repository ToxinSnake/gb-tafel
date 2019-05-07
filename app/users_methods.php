<?php
require_once "SQLiteConnection.php";

const PASSWORD_SHORT = 10;
const PASSWORD_LONG = 11;
const PASSWORD_NOT_ASCII = 12;
const PASSWORD_OKAY = 100;
const USERNAME_SHORT = 20;
const USERNAME_LONG = 21;
const USERNAME_NOT_ASCII = 22;
const USERNAME_OKAY = 200;

function getUsers(){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }

    $sql = "SELECT Username FROM User;";
    return $pdo->query($sql);
}

function validateUsername($username){
    $configs = include('config.php');

    //Länge prüfen
    if(strlen($username) > $configs['USERNAME_MAX_LENGTH']){
        return USERNAME_LONG;
    }

    //Prüfen ob in ASCII-Bereich
    // if(preg_match('/[^\x20-\x7f]/', $username)){
    //     return USERNAME_NOT_ASCII;
    // } 

    return USERNAME_OKAY;
}

function validatePassword($password){
    $configs = include('config.php');

    //Prüfen ob Mindestlänge erreicht ist
    if(strlen($password) < $configs['PASSWORD_MIN_LENGTH']){
        return PASSWORD_SHORT;
    }

    if(strlen($password) > $configs['PASSWORD_MAX_LENGTH']){
        return PASSWORD_LONG;
    }

    //Prüfen ob in ASCII-Bereich
    // if(preg_match('/[^\x20-\x7f]/', $username)){
    //     return PASSWORD_NOT_ASCII;
    // } 

    return PASSWORD_OKAY;
}

function validatePrivilege($privilege){
    $possiblePrivileges = array("admin", "user");
    if(in_array($privilege, $possiblePrivileges)){
        return true;
    }
    else {
        return false;
    }
}

function userExists($username){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }
    
    $sql = "SELECT UNr FROM User WHERE Username IS :username;";
    $statement = $pdo->prepare($sql);
    $statement->execute([':username' => $username]);
    if(count($statement->fetchAll()) != 0){
        return true;
    } else {
        return false;
    }
}

function addUser($username, $password, $privilege){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    switch(validateUsername($username)){
        case USERNAME_LONG:
            throw new Exception("Benutzername zu lang!");
            break;  
    }

    switch(validatePassword($password)){
        case PASSWORD_SHORT:
            throw new Exception("Passwort zu kurz!!"); 
            break;
        case PASSWORD_LONG:
            throw new Exception("Passwort zu lang!");
            break;
    }

    if(!validatePrivilege($privilege)){
        throw new Exception("Privileg existiert nicht!");
    }

    if(userExists($username)){
        throw new Exception("Benutzer existiert bereits!"); 
    }

    //Mit BCRYPT hashen
    $passwdHash = password_hash($password, PASSWORD_BCRYPT);

    $sql = "INSERT INTO User (Username, Password, Privilege) VALUES (:username, :passhash, :privilege);";
    $statement = $pdo->prepare($sql);
    $rtValue = $statement->execute([':username' => $username,
                         ':passhash' => $passwdHash,
                         ':privilege' => $privilege]);
    
    return $rtValue;
}

function changePrivilege($username, $privilege){
    if($username == "admin"){
        throw new Exception("Privilegien von diesem Nutzer dürfen nicht geändert werden!");
    }
    
    if(!userExists($username)){
        throw new Exception("Benutzer existiert nicht!"); 
    }

    if(!validatePrivilege($privilege)){
        throw new Exception("Privileg existiert nicht!");
    }

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }
    
    $sql = 'UPDATE User
    SET Privilege = :privilege
    WHERE Username = :username;';
    $statement = $pdo->prepare($sql);
    $rtValue = $statement->execute([ //TRUE on success, FALSE else
        ':privilege' => $privilege,
        ':username' => $username]);

    return $rtValue;
}

function deleteUser($username){
    if($username == "admin"){
        throw new Exception("Dieser Benutzer kann nicht gelöscht werden!");
    }

    if(!userExists($username)){
        throw new Exception("Benutzer existiert nicht!"); 
    }

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = "DELETE FROM User WHERE Username IS :username";
    $statement = $pdo->prepare($sql);
    $statement->execute([':username' => $username]);

    return $statement;
}

function changePassword($username, $password){
    if(!userExists($username)){
        throw new Exception("Benutzer existiert nicht!"); 
    }

    switch(validatePassword($password)){
        case PASSWORD_SHORT:
            throw new Exception("Passwort zu kurz!!"); 
            break;
        case PASSWORD_LONG:
            throw new Exception("Passwort zu lang!");
            break;
    }

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    //Mit BCRYPT hashen
    $passwdHash = password_hash($password, PASSWORD_BCRYPT);

    $sql = 'UPDATE User
    SET Password = :password
    WHERE Username = :username;';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
        ':password' => $passwdHash,
        ':username' => $username]);

    return $rtvalue;
}
?>