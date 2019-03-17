<?php
//Gibt eine html select Liste mit Abteilungen für die jeweils angewählte Firma zurück
//Falls GET-Parameter leer ist, wird ein leeres Select Feld zurückgegeben
//Falls die Firma keine Abteilung besitzt, wird ein leeres Select Feld zurückgegeben
require_once "shared_methods.php";

$company = $_GET["company"];

if(!(empty($company)) && getDepartmentsRowCount($company) != 0){
    $currentDepartments = getDepartments($_GET["company"]);
?> 
<select name="departmentList" id="departmentList">
<?php
    foreach($currentDepartments as $department) {
?>
    <option value="<?php echo $department['DName']; ?>"><?php echo $department['DName']; ?></option>
<?php 
    }
?>
</select>
<?php
} else {
?>
<select name="departmentList" id="departmentList" disabled>
    <option value=""></option>
</select>
<?php 
} ?>