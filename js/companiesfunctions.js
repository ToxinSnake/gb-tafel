function departmentChange(){                               
    // Sobald eine Firma ausgewählt wird               
    var optionValue = jQuery("select[name='delDepCompany']").val();                                             
    jQuery.ajax({
      type: "GET",
      url: "../app/cmp_ajaxlist.php",
      data: "delDepCompany="+optionValue,
      success: function(response){
        jQuery("#depSelector").html(response);
      }
    });             
} 