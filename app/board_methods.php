<?php

function connect()
{
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

function getTodayBirthdays(){
    $pdo = connect();
    if (! ($pdo instanceof PDO)) {
        throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }
    $sql = 
    "SELECT Person.Firstname, Person.Lastname, Company.CName, Department.DName
     FROM Person
     INNER JOIN Company_Department ON Person.Company_Department_Id IS Company_Department.CoDeId
     INNER JOIN Company ON CId IS Company.CNr
     INNER JOIN Department ON DId IS Department.DNr
     WHERE strftime('%m-%d', Birthday) IS strftime('%m-%d',date('now'));";
     
     return $pdo->query($sql);
}

/**
 * Gibt alle Geburtstage an welche, ausgehend von Heute, mitgegebene Anzahl Tage in der Vergangenheit liegen
 */
function getPastBirthdays($numberOfDays){
    $pdo = connect();
    if (! ($pdo instanceof PDO)) {
        throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }
    $sql = 
    "SELECT Person.Firstname, Person.Lastname, Company.CName, Department.DName
     FROM Person
     INNER JOIN Company_Department ON Person.Company_Department_Id IS Company_Department.CoDeId
     INNER JOIN Company ON CId IS Company.CNr
     INNER JOIN Department ON DId IS Department.DNr
     WHERE strftime('%m-%d', Birthday) IS strftime('%m-%d',date('now','-".$numberOfDays." day'));";
     
     return $pdo->query($sql);
}

/**
 * Returns resultset of birthdays starting from yesterday. Birthdays that were most recently are at the top.
 * 
 * @throws Exception
 * @return PDOStatement
 */

function getPast()
{
    $pdo = connect();
    if (! ($pdo instanceof PDO)) {
        throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }
    $sql = 
    "SELECT Firstname, Lastname, Birthday
     FROM Person
     ORDER BY (CASE WHEN strftime('%m-%d', Birthday) < strftime('%m-%d',date('now')) THEN 0 ELSE 1 END),
     strftime('%m-%d', Birthday) DESC
     LIMIT 3;";
    
    return $pdo->query($sql);
}

/*
 * Returns resultset of birthdays sorted by date. Birthdays of today are always at the top.
 */
function getCurrentAndUpcoming()
{
    $pdo = connect();
    if (! ($pdo instanceof PDO)) {
        throw new Exception("Verbindung zu DB fehlgeschlagen!");
    }

    $sql = 
    "SELECT Firstname, Lastname, Birthday
     FROM Person
     ORDER BY (CASE WHEN strftime('%m-%d', Birthday) >= strftime('%m-%d',date('now')) THEN 0 ELSE 1 END),
     strftime('%m-%d', Birthday)
     LIMIT 5;";

    return $pdo->query($sql);
}

$trans = array(
    'Monday' => 'Montag',
    'Tuesday' => 'Dienstag',
    'Wednesday' => 'Mittwoch',
    'Thursday' => 'Donnerstag',
    'Friday' => 'Freitag',
    'Saturday' => 'Samstag',
    'Sunday' => 'Sonntag',
    'January' => 'Januar',
    'February' => 'Februar',
    'March' => 'März',
    'April' => 'April',
    'May' => 'Mai',
    'June' => 'Juni',
    'July' => 'Juli',
    'August' => 'August',
    'September' => 'September',
    'October' => 'Oktober',
    'November' => 'November',
    'December' => 'Dezember'
);

?>
