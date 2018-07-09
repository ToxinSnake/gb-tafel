<?php
include "SQLiteConnection.php";

function testConnection(){
  $pdo = (new SQLiteConnection())->connect();
  if($pdo != null){
    $rtmsg = "Connected successfully!";
  }else{
    $rtmsg = "Connection failed";
  }
  return $rtmsg;
}
 ?>
