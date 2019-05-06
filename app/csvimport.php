#!/usr/bin/php7.2
<?php
require_once "SQLiteConnection.php";
require_once "companies_methods.php";
require_once "shared_methods.php";

//Connect to DB
$pdo = (new SQLiteConnection())->connect();
if(!($pdo instanceof PDO)){
    throw new Exception("Verbindung zur DB gescheitert!");
}

echo "CSV-Import Test!\n";

$file = fopen("test.csv", "r");

/*
INSERT INTO Company(CName) 
SELECT 'Nowebau' 
WHERE NOT EXISTS(SELECT 1 FROM Company WHERE CName IS 'Nowebau');

INSERT INTO Department(DName) 
SELECT 'Fibu' 
WHERE NOT EXISTS(SELECT 1 FROM Department WHERE DName IS 'Fibu');

INSERT INTO Company_Department (CId, DId)
SELECT CNr, DNr FROM Company, Department WHERE CName IS "Nowebau" AND DName IS "Fibu" AND
NOT EXISTS
(
 SELECT Company_Department.CoDeId FROM Company_Department
 INNER JOIN Company ON Company_Department.CId IS Company.CNr
 INNER JOIN Department ON Company_Department.DId IS Department.DNr
 WHERE Company.Cname IS "Nowebau" AND Department.DName IS "Fibu"
);

SELECT * FROM Company;
SELECT * FROM Department;
SELECT * FROM Company_Department;

*/

$rowCount = 0;
//[0] => Name, [1] => Vorname, [2] => GB, [3] => Company, [4] => Department
while(!feof($file)){
    $row = fgetcsv($file);
    try{
        addCompanyToDb($row[3]);
        addDepartmentToDb($row[3], $row[4]);
    }
    catch(Exception $e){
        echo "Reihe {$rowCount} ({$row[0]}): {$e->getMessage()}\n";
    }
    $rowCount++;
}
fclose($file);
?>