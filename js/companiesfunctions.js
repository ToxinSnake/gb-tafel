function departmentChange(){                               
    // Sobald eine Firma ausgewählt wird               
    var optionValue = jQuery("select[name='delDepCompany']").val();                                             
    jQuery.ajax({
      type: "GET",
      url: "../app/cmp_ajaxlist.php",
      data: "company="+optionValue,
      success: function(response){
        jQuery("#depSelector").html(response);
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