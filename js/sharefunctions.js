
/*
Kann benutzt werden um das Department-Select-Feld zu ändern, wenn eine Firma angewählt wird
selectId = Select Feld mit Firmen
depSelectName = name-Attribut des neuen Select Felds
depSelectId = ID des div Container, in den das neue Feld gelegt wird
*/
function departmentChange(selectId, depSelectName, depSelectId, ){                               
    // Sobald eine Firma ausgewählt wird               
    var optionValue = jQuery("select[name="+selectId+"]").val();                                             
    jQuery.ajax({
      type: "GET",
      url: "../app/cmp_ajaxlist.php",
      data: "company="+optionValue+"&depSelectName="+depSelectName,
      success: function(response){
        jQuery("#"+depSelectId).html(response);
      }
    });
  } 