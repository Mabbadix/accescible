$(".soutiens1").click(function(){
    $.ajax({
        async: false,
        type: 'GET',
        url: 'ajoutSoutien.php?id='+idS
    })
})