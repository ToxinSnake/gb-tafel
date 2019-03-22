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

function validateName(name){

  if(!(name.match(/[A-Za-z]+/g))){
    return false;
  } else {
    return true;
  }
}

function editEntryStart(pnr){

  var textIds = ["fn-"+pnr, "ln-"+pnr, "bd-"+pnr, "cn-"+pnr, "dn-"+pnr];
  var inputIds = ["edit-fn-"+pnr, "edit-ln-"+pnr, "edit-bd-"+pnr, "edit-cn-"+pnr, "edit-dn-"+pnr];
  var TEXTFIELDINDEX = 2;
    
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
  //html von textIds füllen (nicht Firmen und Abteilungswahl)
  for(i = 0; i <= TEXTFIELDINDEX; i++){
    document.getElementById(inputIds[i]).value = document.getElementById(textIds[i]).innerHTML;
  }
  //Save- und Abort Button einblenden
  document.getElementById("save-"+pnr).style.display = "inline";
  document.getElementById("save-"+pnr).style.visibility = "visible";
  document.getElementById("abort-"+pnr).style.display = "inline";
  document.getElementById("abort-"+pnr).style.visibility = "visible";
}

function editEntryEnd(pnr){

  var textIds = ["fn-"+pnr, "ln-"+pnr, "cn-"+pnr, "dn-"+pnr, "bd-"+pnr];
  var inputIds = ["edit-fn-"+pnr, "edit-ln-"+pnr, "edit-cn-"+pnr, "edit-dn-"+pnr, "edit-bd-"+pnr];
  var firstName = document.getElementById(inputIds[0]).value;
  var lastName = document.getElementById(inputIds[1]).value;
  var company = document.getElementById(inputIds[2]).value;
  var department = document.getElementById(inputIds[3]).value;
  var birthday = document.getElementById(inputIds[4]).value;

  //Validierung
  if(validateName(firstName) == false){
    alert("Vorname muss mindestens ein Zeichen enthalten und keine Zahl!");
    return;
  }
  if(validateName(lastName) == false){
    alert("Nachname muss mindestens ein Zeichen enthalten und keine Zahl!");
    return;
  }

  //TODO: rest validieren

  //ajax änderung durchführen
  $.ajax({
    type: "POST",
    url: 'search.php',
    data: { pnr: pnr,
            changeFirstName: firstName,
            changeLastName: lastName,
            changeCompany: company,
            changeDepartment: department,
            changeBirthday: birthday},
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

    //Save- und Abbrechen Button ausblenden
    document.getElementById("save-"+pnr).style.display = "none";
    document.getElementById("abort-"+pnr).style.display = "none";

    //Delete und Edit wieder einblenden
    var nodesdel = document.getElementsByClassName("del");
    var nodesedit = document.getElementsByClassName("edit");
    for (i = 0; i < nodesdel.length; i++) {
      nodesdel[i].style.display = "inline";
      nodesedit[i].style.display = "inline";
    } 
  }

  function abortEdit(pnr){
    var textIds = ["fn-"+pnr, "ln-"+pnr, "cn-"+pnr, "dn-"+pnr, "bd-"+pnr];
    var inputIds = ["edit-fn-"+pnr, "edit-ln-"+pnr, "edit-cn-"+pnr, "edit-dn-"+pnr, "edit-bd-"+pnr];

    //Inputs ausblenden
    for(i = 0; i < inputIds.length; i++){
      document.getElementById(inputIds[i]).style.display = "none";
    }

    //Texte wieder einblenden
    for(i = 0; i < textIds.length; i++){
      document.getElementById(textIds[i]).style.display = "block";
    }

    //Save- und Abbrechen Button ausblenden
    document.getElementById("save-"+pnr).style.display = "none";
    document.getElementById("abort-"+pnr).style.display = "none";

    //Delete und Edit wieder einblenden
    var nodesdel = document.getElementsByClassName("del");
    var nodesedit = document.getElementsByClassName("edit");
    for (i = 0; i < nodesdel.length; i++) {
      nodesdel[i].style.display = "inline";
      nodesedit[i].style.display = "inline";
    }
  }