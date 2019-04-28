<?php
require_once "SQLiteConnection.php";

function updateNews($headline, $text, $publish, $username){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zur DB gescheitert!");
    }

    //Input sanitizen
    $headline = filter_var($headline, FILTER_SANITIZE_STRING);
    $text = filter_var($text, FILTER_SANITIZE_STRING);

    $date = time();

    $sql = 'UPDATE News
    SET Headline = :headline,
    Content = :content,
    Author = :username,
    Date = :date,
    Publish = :publish';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([ //TRUE on success, FALSE else
        ':headline' => $headline,
        ':content' => $text,
        ':username' => $username,
        ':date' => $date,
        ':publish' => $publish])
    ;
}

function getNews(){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
      throw new Exception("Verbindung zur DB gescheitert!");
    }

    $sql = "SELECT Headline, Content, Publish FROM News";
    return $pdo->query($sql)->fetch();
}


?>