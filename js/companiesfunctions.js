/*
Kann benutzt werden um das Department-Select-Feld zu ändern, wenn eine Firma angewählt wird
selectId = Select Feld mit Firmen
depSelectName = name-Attribut des neuen Select Felds
divSelectId = ID des div Container, in den das neue Feld gelegt wird
depSelectId = ID-Attribut des neuen Select Felds
PNr = Personen Nummer, um aktuelle Abteilung finden zu können
*/
function departmentChangeNew(selectId, depSelectName, divSelectId){
  // Sobald eine Firma ausgewählt wird               
  var optionValue = jQuery("select[name="+selectId+"]").val();                                             
  jQuery.ajax({
    type: "GET",
    url: "../app/cmp_ajaxlist.php",
    data: "company="+optionValue+"&depSelectName="+depSelectName+"&mode=new",
    success: function(response){
      jQuery("#"+divSelectId).html(response);
    }
  });
} 

function confirmDeleteCompany(selectField){
  var sel = document.getElementById(selectField);
  var opt = sel.options[sel.selectedIndex];
  return confirm(opt.text+" wirklich löschen?\nAlle Abteilungen dieser Firma werden gelöscht!\nAlle Personen die mit dieser Firma assoziiert sind, werden gelöscht!");
}

function confirmDeleteDepartment(selectField){
  var sel = document.getElementById(selectField);
  var opt = sel.options[sel.selectedIndex];
  return confirm(opt.text+" wirklich löschen?\nAlle Personen die mit dieser Abteilung assoziiert sind, werden gelöscht!");
}