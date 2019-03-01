<?php
include "SQLiteConnection.php";


function addCompanyToDb($company){

    //validate company, check if it already exists
    //TODO

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    else {
        $sql = 'INSERT INTO Company (Cname) VALUES (:cname)';
        $statement = $pdo->prepare($sql);
        $rtvalue = $statement->execute([':cname' => $company]);
    }

    return $rtvalue;

}

function addDepartmentToDb($company, $department){
    
    //validate department, check if it already exists
    //TODO

    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    //ID der Company finden
    $sql = 'SELECT CNr FROM Company WHERE CName IS :company';
    $statement = $pdo->prepare($sql);
    $statement->execute([':company' => $company]);
    $CId = $statement->fetch()['CNr'];
    
    //Abteilung einfügen
    $sql = 'INSERT INTO Department (Dname) VALUES (:department)';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([':department' => $department]);

    //Wenn einfügen scheitert aus irgendwelchen Gründen
    if($rtvalue == false){
        return false;
    }

    //DId von neue eingefügter Abteilung holen
    $sql = 'SELECT DNr FROM Department WHERE DName IS :department';
    $statement = $pdo->prepare($sql);
    $statement->execute([':department' => $department]);
    $DId = $statement->fetch()['DNr'];

    //Einfügen von CId und DId in die junction Tabelle
    $sql = 'INSERT INTO Company_Department (CId, DId) VALUES (:cid, :did)';
    $statement = $pdo->prepare($sql);
    $rtvalue = $statement->execute([
        ':cid' => $CId, 
        ':did' => $DId
    ]);
    
    return $rtvalue;

}

function getCompanies(){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        throw new Exception("Verbindung zur DB gescheitert!");
    }
    $sql = 'SELECT Cname FROM Company';
    return $pdo->query($sql);
}

function getDepartments($company){
    $pdo = (new SQLiteConnection())->connect();
    if(!($pdo instanceof PDO)){
        echo "KAPUTT";
        throw new Exception("Verbindung zur DB gescheitert!");
    }

    //Gibt alle Abteilungen der Firma zurück
    $sql = 'SELECT DName FROM Department WHERE DNr IN (SELECT DId FROM Company_Department WHERE CId IS (SELECT CNr FROM Company WHERE CName IS :company));';
    $statement = $pdo->prepare($sql);
    $statement->execute([':company' => $company]);

    return $statement;
}

?>