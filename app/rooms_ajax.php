<?php
header('Content-Type: application/json');

require_once "SQLiteConnection.php";

//Connect to DB
$pdo = (new SQLiteConnection())->connect();
if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zur DB gescheitert!");
}

$roomId = $_GET["roomId"];
$sql = 'SELECT Roomname, Line1, Line2, Line3, Occupied FROM Room WHERE RId IS '.$roomId;
$result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

$data = array (
    'Roomname' => $result["Roomname"],
    'Line1' => $result["Line1"],
    'Line2' => $result["Line2"],
    'Line3' => $result["Line3"],
    'Occupied' => $result["Occupied"],
);

echo (json_encode($data));
?>