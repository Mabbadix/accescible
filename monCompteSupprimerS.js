//récup des div qui doivent s'afficher pour changer monCompte
var affiche = document.getElementById("afficheInfos");
var formModif = document.getElementById('formModif');
  function modifierMonCompte(){
    affiche.style.display="none";
    formModif.style.display="";
    //x.innerHTML = "<p> <br/> <strong>Le son est good</strong> <br/> Pour répondre à notre problème nous allons utiliser l’acoustique.</p>";
  }
  function annuler(){
    affiche.style.display="";
    formModif.style.display="none";
  }

//gestion des suppressions des signlements de l'utilisateurs
$(".button--circle").click(function(){
  if (window.confirm("Voulez-vous vraiment supprimer ce signalement?")){
    $.ajax({
        async: false,
        type: 'GET',
        url: 'monCompteSupprimerS.php?id='+idS
    });
  }
});

//gestion de la suppression du compte de l'utilisateur
$(".seDesinscrire").click(function(){
  if (window.confirm("Attention vous êtes sur le point d'effacer irrémédiablement votre compte. Voulez-vous continuer ?")){
    $.ajax({
        async: false,
        type: 'GET',
        url: 'monCompteDesinscription.php?emailU='+email
    });
    window.setTimeout("location=(\'userCarte.php\');",10)
  }
});
