function deleteEntry(pnr){
    if(confirm("Wirklich löschen?")){
      $.ajax({
        type: "POST",
        url: 'search.php',
        data: { del: pnr},
        success: function(){
            document.getElementById(pnr).style.display = "none";
        }
      });
    }
  }

  function editEntryStart(pnr){

    var textIds = ["fn-"+pnr, "ln-"+pnr, "cn-"+pnr, "dn-"+pnr, "bd-"+pnr];
    var inputIds = ["edit-fn-"+pnr, "edit-ln-"+pnr, "edit-cn-"+pnr, "edit-dn-"+pnr, "edit-bd-"+pnr];
    
    //Text ausblenden
    for(i = 0; i < textIds.length; i++){
      document.getElementById(textIds[i]).style.display = "none";
    }

    //Delete und Edit überall ausblenden
    var nodesdel = document.getElementsByClassName("del");
    var nodesedit = document.getElementsByClassName("edit");
    for (i = 0; i < nodesdel.length; i++) {
      nodesdel[i].style.display = "none";
      nodesedit[i].style.display = "none";
    } 

    //Inputs einblenden
    for(i = 0; i < inputIds.length; i++){
      document.getElementById(inputIds[i]).style.display = "block";
    }

    //Save Button einblenden
    document.getElementById("save-"+pnr).style.display = "inline";
    document.getElementById("save-"+pnr).style.visibility = "visible";
  }

  function editEntryEnd(pnr){

    var textIds = ["fn-"+pnr, "ln-"+pnr, "cn-"+pnr, "dn-"+pnr, "bd-"+pnr];
    var inputIds = ["edit-fn-"+pnr, "edit-ln-"+pnr, "edit-cn-"+pnr, "edit-dn-"+pnr, "edit-bd-"+pnr];

    //ajax änderung durchführen
    $.ajax({
      type: "POST",
      url: 'search.php',
      data: { pnr: pnr,
              changeFirstName: document.getElementById(inputIds[0]).value,
              changeLastName: document.getElementById(inputIds[1]).value,
              changeBirthday: document.getElementById(inputIds[4]).value},
      success: function(){
        //Inputs auf Texte übertragen
        for(i = 0; i < textIds.length; i++){
        document.getElementById(textIds[i]).innerHTML = document.getElementById(inputIds[i]).value;
        }
      },
      error: function(){
        alert("Es gab einen Fehler!");
      }
    });

    //Inputs ausblenden
    for(i = 0; i < inputIds.length; i++){
      document.getElementById(inputIds[i]).style.display = "none";
    }

    //Texte wieder einblenden
    for(i = 0; i < textIds.length; i++){
      document.getElementById(textIds[i]).style.display = "block";
    }

    //Save Button ausblenden
    document.getElementById("save-"+pnr).style.display = "none";

    //Delete und Edit wieder einblenden
    var nodesdel = document.getElementsByClassName("del");
    var nodesedit = document.getElementsByClassName("edit");
    for (i = 0; i < nodesdel.length; i++) {
      nodesdel[i].style.display = "inline";
      nodesedit[i].style.display = "inline";
    } 
  }