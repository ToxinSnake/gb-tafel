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
    $defaultPass = password_hash("admin", PASSWORD_BCRYPT);
    $sqlInit = 
     'CREATE TABLE Person (
      PNr INTEGER PRIMARY KEY,
      Firstname TEXT NOT NULL,
      Lastname TEXT NOT NULL,
      Birthday TEXT NOT NULL,
      Company_Department_Id INTEGER NOT NULL);
      
      CREATE TABLE Company (
      CNr INTEGER PRIMARY KEY,
      CName TEXT NOT NULL);
      
      CREATE TABLE Department (
      DNr INTEGER PRIMARY KEY,
      DName TEXT NOT NULL);
      
      CREATE TABLE Company_Department (
      CoDeId INTEGER PRIMARY KEY,
      CId INTEGER,
      DId INTEGER);
      
      CREATE TABLE User (
      UNr INTEGER PRIMARY KEY,
      Username TEXT NOT NULL,
      Password TEXT NOT NULL,
      Privilege TEXT NOT NULL);

      CREATE TABLE News (
      Headline TEXT,
      Content TEXT,
      Author TEXT,
      Date TEXT,
      Publish BOOLEAN);

      CREATE TABLE Feed (
      FId INTEGER PRIMARY KEY,
      Link TEXT NOT NULL
      );

      INSERT INTO News (Headline, Content, Publish) VALUES (
        "Überschrift", "Text hier eingeben...", 0);
      
      INSERT INTO User (Username, Password, Privilege) VALUES (
        "admin", "'.$defaultPass.'", "admin");'
    ;
    $pdo;

    if(file_exists($path)){
      return self::DB_ALREADY_EXISTS;
    }
    else {
      try{
        $pdo = new PDO("sqlite:".$path);
      } //endtry
      catch (PDOException $e){
        print($e->getMessage());
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
