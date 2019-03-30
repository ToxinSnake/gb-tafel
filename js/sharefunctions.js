
/*
Kann benutzt werden um das Department-Select-Feld zu ändern, wenn eine Firma angewählt wird
selectId = Select Feld mit Firmen
depSelectName = name-Attribut des neuen Select Felds
divSelectId = ID des div Container, in den das neue Feld gelegt wird
depSelectId = ID-Attribut des neuen Select Felds
PNr = Personen Nummer, um aktuelle Abteilung finden zu können
*/
function departmentChange(selectId, depSelectName, divSelectId, depSelectId, PNr, search){
  if (depSelectId === undefined) depSelectId = "";
  if (depSelectName === undefined) depSelectName = "";
  if (PNr === undefined) PNr = "";
  if (search === undefined) search = 0;
  // Sobald eine Firma ausgewählt wird               
  var optionValue = jQuery("select[name="+selectId+"]").val();                                             
  jQuery.ajax({
    type: "GET",
    url: "../app/cmp_ajaxlist.php",
    data: "company="+optionValue+"&depSelectName="+depSelectName+"&depSelectId="+depSelectId+"&PNr="+PNr+"&search="+search,
    success: function(response){
      jQuery("#"+divSelectId).html(response);
    }
  });
} 