<?php

class SQLiteConnection{

  /* Constants */
  const SUCCESS = 0;
  const DB_ALREADY_EXISTS = 10;

  const CONNECTION_FAILED = 100;
  const CREATION_FAILED = 101;
  const MISSING_TABLES = 102;
  const DB_DOES_NOT_EXISTS = 103;

  /**
  * Create new DB if and only if it does not already exist.
  * Path to DB as given in config.php
  *
  * @return - Statuscode
  */

  public function create(){
    $configs = include('config.php');
    $path = "../".$configs['PATH_TO_SQLITE_FILE'];
    $sqlInit = 'CREATE TABLE Person (
      PNr INTEGER PRIMARY KEY,
      Firstname TEXT NOT NULL,
      Lastname TEXT NOT NULL,
      Birthday TEXT NOT NULL)';
    $pdo;

    if(file_exists($path)){
      return self::DB_ALREADY_EXISTS;
    }
    else {
      try{
        $pdo = new PDO("sqlite:".$path);
      } //endtry
      catch (PDOException $e){
        return self::CREATION_FAILED;
      } //endcatch

      $pdo->exec($sqlInit); //Tabellen anlegen
      return self::SUCCESS;
    } //endelse
  }

  /**
   * Connect to sqlite DB as given in config.php.
   * Does NOT create a new DB when no file exists.
   * Returns PDO with connected DB or Errorcode as Integer.
   *
   * @return - PDO, Statuscode
   */

  public function connect(){
    $configs = include('config.php');
    $path = "../".$configs['PATH_TO_SQLITE_FILE'];


    if(file_exists($path)){
      try{
        $dbh = new PDO("sqlite:".$path);
        return $dbh;
      } //endtry
      catch (PDOException $e){
        return self::CONNECTION_FAILED;
      } //endcatch
    }
    else {
      return self::DB_DOES_NOT_EXISTS;
    } //endelse
  }

}
 ?>
