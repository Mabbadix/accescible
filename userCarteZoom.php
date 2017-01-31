<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc"></script>
<script>
// Geolocation + Marker
//Récuperation de la Div "mapcanvas" du html
var mapcanvas = document.getElementById("mapcanvas");
var x = document.getElementById("mapcanvas");//utilisée pour l'affichage des erreurs uniquement
//Geolocation sur map


function zoomPost(lat, lng, idS){
var latlngG = new google.maps.LatLng(lat, lng);
var myOptions = {
zoom: 17
, center: latlngG
, mapTypeId: google.maps.MapTypeId.ROADMAP
};
// generation de la map
var map = new google.maps.Map(mapcanvas, myOptions);

//on créé un obj fenetre de map
var infowindow = new google.maps.InfoWindow();

//on recentre la carte (=en refaire une)

var marker = new google.maps.Marker({
    position: new google.maps.LatLng(lat, lng),
    map: map,
    icon: "img/maker.svg",
    animation:google.maps.Animation.DROP,
  });
infowindow.open(map, marker);
//on ecoute le marker et si click on affiche info
marker.addListener('click', function() {
    location.reload();
  });

infowindow.setContent('<div class="crossPostit" id="crossPostit"" >Ciblé !</div>')


//On modifie le postit pour que sélection soit visible et qu'il soit possible de revenir sur la vue générale

var postits = document.getElementsByClassName('msgsignal');
var post = document.getElementById(idS);
var cross = document.getElementById("crossPostit"+idS);
post.style.backgroundColor="rgba(34,112,155,0.3)";
cross.style.display="";

}//fin de zoomPost()

function revenir (){
  location.reload();
}

//Funtion de vues initial

  function showPosition(position) {
    var latlngG = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    //x.innerHTML = latlng;

    var myOptions = {
      zoom: 12
      , center: latlngG
      , mapTypeId: google.maps.MapTypeId.ROADMAP
    };
    // generation de la map
    var map = new google.maps.Map(mapcanvas, myOptions);
    //MAJ de la map en focntion des new Latlng
    var majMap = map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
    // création Maker et son placement pour chaque latlng qu'il y a dans la BDD PHP/JS
    <?php foreach ($tabLatLng as $tab){ ?>
    new google.maps.Marker({
        position: new google.maps.LatLng(<?php echo $tab["latlng"]?>),
        map: map,
        icon: "img/maker.svg",
        animation:google.maps.Animation.BOUNCE//google.maps.Animation.DROP
    });
  <?php } ?>

  }//fin de showposition

  // Error si carte impossible à afficher
  function showError(error) {
    switch (error.code) {
    case error.PERMISSION_DENIED:
      x.innerHTML = "User denied the request for Geolocation.</br><video class='videoR' controls preload='auto' poster='img/logo73.svg' ><source src='img/rendu_anim_handicap.mp4' type='video/mp4'>Your browser does not support the video tag.</video >"
      break;
    case error.POSITION_UNAVAILABLE:
      x.innerHTML = "Location information is unavailable.</br><video class='videoR' controls preload='auto' poster='img/logo73.svg' ><source src='img/rendu_anim_handicap.mp4' type='video/mp4'>Your browser does not support the video tag.</video >"
      break;
    case error.TIMEOUT:
      x.innerHTML = "The request to get user location timed out.</br><video class='videoR' controls preload='auto' poster='img/logo73.svg' ><source src='img/rendu_anim_handicap.mp4' type='video/mp4'>Your browser does not support the video tag.</video >"
      break;
    case error.UNKNOWN_ERROR:
      x.innerHTML = "An unknown error occurred."
      break;
    }
  }

  //Si géolocalisation supporter par navigateur alors appelle de fonction
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition, showError);
  }
  else {
    x.innerHTML = "Geolocation is not supported by this browser.</br><video class='videoR' controls preload='auto' poster='img/logo73.svg' ><source src='img/rendu_anim_handicap.mp4' type='video/mp4'>Your browser does not support the video tag.</video >";
  }

  /*var marker = new google.maps.Marker({
      position: voirS,
      map: map,
      icon: "img/maker.svg",
      animation:google.maps.Animation.DROP,
    });*/

  /*marker.setPlace({
    placeId: voirS,
    //location: place.geometry.location
  });*/
  // Event de click sur marker de position
  /*google.maps.event.addListener(marker, 'click', function () {
    alert("Par là quoi, à +/- "+position.coords.accuracy+" m à la ronde :))"); //message d'alerte
  });*/
  //autre makerS
  //tableau contenant tous les marqueurs que nous créerons
  /*var tabMarqueurs = new Array();
  //notez la présence de l'argument "event" entre les parenthèses de "function()"
  google.maps.event.addListener(map, 'click', function(event) {
      tabMarqueurs.push(new google.maps.Marker({
          position: event.latLng,//coordonnée de la position du clic sur la carte
          map: map//la carte sur laquelle le marqueur doit être affiché
      }));
  });*/

</script>
