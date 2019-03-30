<?php
//Gibt eine html select Liste mit Abteilungen für die jeweils angewählte Firma zurück
//Falls GET-Parameter leer ist, wird ein leeres Select Feld zurückgegeben
//Falls die Firma keine Abteilung besitzt, wird ein leeres Select Feld zurückgegeben
require_once "shared_methods.php";

//Wenn von Geburtstag anlegen und Firmen verwalten aufgerufen wird
if($_GET["mode"] == "new"){
    $currentDepartments = getDepartments($_GET["company"]);
    ?>
<select name="<?php echo $_GET["depSelectName"] ?>">
    <?php 
    foreach($currentDepartments as $department) { ?>
    <option value="<?php echo $department['DName']; ?>"><?php echo $department['DName']; ?></option>
    <?php 
    }
    ?>
</select>
<?php 
}

//Wenn von der Suche aus aufgerufen wird
elseif($_GET["mode"] == "search"){
    $currentDepartments = getDepartments($_GET["company"]);
    ?>
<select name="<?php echo $_GET["depSelectName"] ?>">
    <option value="%">Alle</option>
    <?php 
    foreach($currentDepartments as $department) { ?>
    <option value="<?php echo $department['DName']; ?>"><?php echo $department['DName']; ?></option>
    <?php 
    } 
}

//Wenn ein Eintrag editiert wird
elseif($_GET["mode"] == "edit"){
    $currentDepartments = getDepartments($_GET["company"]);
    $associatedDepartment = findDepartmentForPerson($_GET["PNr"]);
    ?>
<select id="<?php echo $_GET["depSelectId"] ?>" style="display: block;">
    <?php 
    foreach($currentDepartments as $department) { ?>
    <option value="<?php echo $department['DName']; ?>" <?php if($associatedDepartment == $department['DName']) echo " selected"; ?>><?php echo $department['DName']; ?></option>
    <?php 
    } 
}
?>
</select>
