<?php
const CONNECTION_FAILED = 100;
const DB_DOES_NOT_EXISTS = 103;

function connect(){
    $configs = include ('config.php');
    $path = $configs['PATH_TO_SQLITE_FILE'];

    if (file_exists($path)) {
        try {
            $dbh = new PDO("sqlite:" . $path);
            return $dbh;
        } 
        catch (PDOException $e) {
            return CONNECTION_FAILED;
        }
    } else {
        return DB_DOES_NOT_EXISTS;
    }
}

function getRoom($id){
    //Connect to DB
    $pdo = connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = 'SELECT Roomname, Line1, Line2, Line3, Occupied FROM Room WHERE RId IS :id';
    $statement = $pdo->prepare($sql);
    
    $statement->execute([':id' => $id]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}

function getRoomIds(){
    //Connect to DB
    $pdo = connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }
    
    $sql= 'SELECT RId, Roomname FROM Room;';
    $statement = $pdo->prepare($sql);
    return $pdo->query($sql);
}

?>