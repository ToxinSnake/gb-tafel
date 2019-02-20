function deleteEntry(pnr){
    //if confirm, mit ajax delete aufrufen
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

  function editEntry(pnr){
    alert("Du willst "+pnr+" bearbeiten!");
  }