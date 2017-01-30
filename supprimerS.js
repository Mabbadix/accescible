$(".button--circle").click(function(){
  if (window.confirm("Voulez-vous vraiment supprimer ce signalement?")){
    $.ajax({
        async: false,
        type: 'GET',
        url: 'supprimerS.php?id='+idS
    });

  }
});
