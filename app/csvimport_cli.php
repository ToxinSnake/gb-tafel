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
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

echo "CSV-Import Test!\n";

$file = fopen("test.csv", "r");

/* 
bindParam kann nicht benutzt werden, da die selben Placeholder nicht mehrmals verwendet werden dürfen!

1. Company einfügen falls sie noch nicht existiert
2. Department einfügen falls noch nicht existiert
3. Company_Department setzen, falls noch nicht existiert
*/
$qCompany =
'INSERT INTO Company(CName) 
SELECT :company1
WHERE NOT EXISTS (SELECT 1 FROM Company WHERE CName IS :company2);';

$qDepartment =
'INSERT INTO Department(DName) 
SELECT :department1 
WHERE NOT EXISTS (SELECT 1 FROM Department WHERE DName IS :department2);';

$qCoDe =
'INSERT INTO Company_Department (CId, DId)
SELECT CNr, DNr FROM Company, Department WHERE CName IS :company1 AND DName IS :department1 AND
NOT EXISTS
(
 SELECT Company_Department.CoDeId FROM Company_Department
 INNER JOIN Company ON Company_Department.CId IS Company.CNr
 INNER JOIN Department ON Company_Department.DId IS Department.DNr
 WHERE Company.Cname IS :company2 AND Department.DName IS :department2
);';

$qPerson = 
'INSERT INTO Person (Firstname, Lastname, Birthday, Company_Department_Id)
VALUES (:firstname,:lastname,:birthday,:codeid);';

$sCompany = $pdo->prepare($qCompany);
$sDepartment = $pdo->prepare($qDepartment);
$sCoDe = $pdo->prepare($qCoDe);
$sPerson = $pdo->prepare($qPerson);


$rowCount = 0;
//[0] => Name, [1] => Vorname, [2] => GB, [3] => Company, [4] => Department
while(!feof($file)){
    $row = fgetcsv($file);

    //Datum nach ISO formatieren
    $tempDate = new DateTime($row[2]);
    $row[2] = $tempDate->format('Y-m-d');
    
    $sCompany->execute([
        ':company1' => $row[3],
        ':company2' => $row[3]
    ]);  
    $sDepartment->execute([
        ':department1' => $row[4],
        ':department2' => $row[4]
    ]);
    $sCoDe->execute([
        ':company1' => $row[3],
        ':department1' => $row[4],
        ':company2' => $row[3],
        ':department2' => $row[4]
    ]);
    $codeid = getCompanyDepartmentId($row[3], $row[4]);
    $sPerson->execute([
        ':firstname' => $row[1], 
        ':lastname' => $row[0],
        ':birthday' => $row[2],
        ':codeid' => $codeid
        ]);

    $sCompany->closeCursor();
    $sPerson->closeCursor();
    $rowCount++;
}

fclose($file);
?>