function departmentChange(){                               
    // Sobald eine Firma ausgewählt wird               
    var optionValue = jQuery("select[name='company']").val();                                             
    jQuery.ajax({
      type: "GET",
      url: "../app/cmp_ajaxlist.php",
      data: "company="+optionValue,
      success: function(response){
        jQuery("#depSelector").html(response);
      }
    });
} 