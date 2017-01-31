$(".button--circle").click(function(){
  if (window.confirm("Voulez-vous soutenir ce signalement?")){
    $.ajax({
        async: false,
        type: 'GET',
        url: 'ajoutSoutien.php?id='+idS
    });
  }
});
