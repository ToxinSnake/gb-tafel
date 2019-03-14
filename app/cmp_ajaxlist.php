<?php
//Gibt eine html select Liste mit Abteilungen für die jeweils angewählte Firma zurück
//Nur über ajax aufrufbar
include "companies_methods.php";

$company = $_GET["delDepCompany"];
 
if(!$company) {
    return false;
}
 
$currentDepartments = getDepartments($company);

?> 
<select name="department">
    <?php
        foreach($currentDepartments as $department) {
    ?>
    <option value="<?php echo $department['DName']; ?>"><?php echo $department['DName']; ?></option>
    <?php 
        }
    ?>
</select>