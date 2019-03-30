<?php
//Gibt eine html select Liste mit Abteilungen für die jeweils angewählte Firma zurück
//Falls GET-Parameter leer ist, wird ein leeres Select Feld zurückgegeben
//Falls die Firma keine Abteilung besitzt, wird ein leeres Select Feld zurückgegeben
require_once "shared_methods.php";

$company = $_GET["company"];
$depSelectName = $_GET["depSelectName"];
$depSelectId = $_GET["depSelectId"];
if(!empty($_GET["PNr"])) $Pnr = $_GET["PNr"];
$associatedDepartment = "";

//Benötigt, damit der selected Attribut gesetzt werden kann in der Suchtabelle
if(isset($Pnr)){
    $associatedDepartment = findDepartmentForPerson($Pnr);
}

//Wenn Firma auch Abteilungen hat, ansonsten Leeres Select
if(!(empty($company)) && getDepartmentsRowCount($company) != 0){
    $currentDepartments = getDepartments($_GET["company"]);
    
?> 
<select name="<?php echo $depSelectName ?>" id="<?php echo $depSelectId ?>">
<?php
    if(isset($_GET["search"]) && ($_GET["search"] === 1)) { ?> <option value="%">Alle</option>  <?php } 
    foreach($currentDepartments as $department) {
?>
    <option value="<?php echo $department['DName']; ?>"<?php if($associatedDepartment == $department['DName']) echo " selected"; ?>><?php echo $department['DName']; ?></option>
<?php 
    }
?>
</select>
<?php
} else {
?>
<select name="<?php echo $depSelectName ?>" id="<?php echo $depSelectId ?>" disabled>
    <option value=""></option>
</select>
<?php 
} ?>