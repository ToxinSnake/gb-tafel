<?php

require_once "SQLiteConnection.php";

function addRoom($name){

    validateRoomName($name);

    //Connect to DB
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = 'INSERT INTO Room (Roomname, Occupied) VALUES (:roomname, 0);';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
      ':roomname' => $name
    ]);

    return $rtvalue;
}

function editRoom($id ,$name, $line1, $line2, $line3, $occupied){
    validateRoomName($name);
    $id = filter_var($id, FILTER_SANITIZE_STRING);
    $line1 = filter_var($line1, FILTER_SANITIZE_STRING);
    $line2 = filter_var($line2, FILTER_SANITIZE_STRING);
    $line3 = filter_var($line3, FILTER_SANITIZE_STRING);
    $occupied = filter_var($occupied, FILTER_SANITIZE_STRING);

    $line1 = $line1."";
    $line2 = $line2."";
    $line3 = $line3."";

    //Connect to DB
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = 'UPDATE Room
    SET Roomname = :roomname,
    Line1 = :line1,
    Line2 = :line2,
    Line3 = :line3,
    Occupied = :occupied
    WHERE RId = :id';

    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
        ':roomname' => $name,
        ':line1' => $line1,
        ':line2' => $line2,
        ':line3' => $line3,
        ':occupied' => $occupied,
        ':id' => $id
    ]);

    return $rtvalue;
}

function deleteRoom($id){
    //Connect to DB
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = "DELETE FROM Room WHERE RId IS :id";
    $statement = $pdo->prepare($sql);
    $statement->execute([':id' => $id]); //TRUE on success, FALSE else
  
    return $statement;
  
}

function getRoomById($id){
    //Connect to DB
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = 'SELECT Roomname FROM Room WHERE RId IS :id';
    $statement = $pdo->prepare($sql);
    
    $statement->execute([':id' => $id]);
    return $statement->fetch()[0];
}

function getRooms(){
    //Connect to DB
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = 'SELECT RId, Roomname FROM Room;';
    return $pdo->query($sql);
}

function validateRoomName($name){
    $configs = include('config.php');
    $roomLength = $configs['MAX_ROOM_LENGTH'];

    $name = filter_var($name, FILTER_SANITIZE_STRING);

    if(mb_strlen($name) == 0){
        throw new Exception("Raumname muss mindestens ein Zeichen beinhalten!");
      }
    
    if(mb_strlen($name) > $roomLength ){
        throw new Exception("Raumname zu lang!");
    }
}

?>