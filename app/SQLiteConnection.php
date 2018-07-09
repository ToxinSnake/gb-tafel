<?php

class SQLiteConnection{

  /* Connect to sqlite DB or create new DB if it does not exist */
  /* @return - PDO */

  public function connect(){
    try{
        $configs = include('config.php');
        $pdo_path = "sqlite:../".$configs['PATH_TO_SQLITE_FILE'];
        $dbh = new PDO($pdo_path);
        return $dbh;
    } catch (PDOException $e){
        var_dump($e->getTrace());
        var_dump($configs);
    }
  }
}
 ?>
