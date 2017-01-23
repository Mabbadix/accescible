<script type = "text/javascript"  src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc&signed_in=true&libraries=places" async defer>
// async defer = pas synchronization page ce qui permets de moins attendre
</script>
<script type = "text/javascript" >
/******pour l'information si champs pas rempli*********/
$(document).ready(function(){
$("#notif").fadeOut(3000);
});


/******VARIABLES COMMUNES********************/
/*Var pour map*/
var mapcanvas = document.getElementById("mapcanvas");
var x = document.getElementById("mapcanvas");//utilisée pour l'affichage des erreurs uniquement

/***************MAPS AFFICHEE DE BASE*********************/
// test de la géoloc
if (navigator.geolocation) {
  //récupération infos position + lancement de showPosition
  navigator.geolocation.getCurrentPosition(showPosition, showError);
} else {
  x.innerHTML = "Geolocation is not supported by this browser.";
}

//Affiche la position de l'utilisateur;
function showPosition(position) {
  //configuration et affichage map
  var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
  var myOptions = {
    zoom: 12,
    center: latlng
  };
  var map = new google.maps.Map(mapcanvas, myOptions);
  //mise à jour maps;
  var majMap = map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
}

// Gestion des erreurs en cas de non-affichage de la map
function showError(error) {
  switch(error.code) {
      case error.PERMISSION_DENIED:
          x.innerHTML = "User denied the request for Geolocation. Please active your Geolocalisation."
          break;
      case error.POSITION_UNAVAILABLE:
          x.innerHTML = "Location information is unavailable."
          break;
      case error.TIMEOUT:
          x.innerHTML = "The request to get user location timed out."
          break;
      case error.UNKNOWN_ERROR:
          x.innerHTML = "An unknown error occurred."
          break;
  }
}

/***************Autocpmpletation + Geocodage *********************/
/*Displays an address form, using the autocomplete feature
of the Google Places API to help users fill in the information.*/

/*Variable pour l'autocomplete et geocode*/
var autocomplete;

//this var use same name of id component and google array result after autocomplete (=address_components)
var componentForm = {
  street_number: 'short_name',
  route: 'long_name',
  locality: 'long_name',
  administrative_area_level_1: 'short_name',
  country: 'long_name',
  postal_code: 'short_name',
};

var input = /** @type {!HTMLInputElement} */ (document.getElementById('autocomplete'));

//function qui créé l'objet autocplete etl'écoute
function initAutocomplete() {
    // Create the autocomplete object, restricting the search to geographical location types.
    autocomplete = new google.maps.places.Autocomplete((input),
      {types: ['geocode'], 'componentRestrictions':{country:'FR'}});
    // Listen "autocomplete" objet. When the user selects an address from the dropdown (=place_changed), populate the address fields in the form(=fillInAddress).
    autocomplete.addListener('place_changed', fillInAddress);

}

// quand autocomplete selectionné on complete les champs = [START region_fillform]
function fillInAddress(geoCode) {
  // Get the place details from the autocomplete object (une fois l'autocomplete fait, l'API retourne un objet avec plein d'infos ce qui évite le géocodage).

  if (geoCode){//on distingue en fonction du fait que l'adresse probient de la geoloc ou de l'autocompletion
    var place = geoCode;
  }else {
    var place = autocomplete.getPlace();
  }

  //ici on rend dispo les component du form + réinit
  for (var component in componentForm) {
    document.getElementById(component).value = '';
    document.getElementById(component).disabled = false;
  }

  // Get each component of the address from the place details and fill the corresponding field on the form.
  for (var i = 0; i < place.address_components.length; i++) {
    var addressType = place.address_components[i].types[0];
    if (componentForm[addressType]) {
      var val = place.address_components[i][componentForm[addressType]];
      document.getElementById(addressType).value = val;
    }
  }

  //Remplacement de "document.getElementById('latlng').value = "new google.maps.LatLng"+place.geometry.location;" pour avoir des données BDD plus facile a traiter
  var coordS =  place.geometry.location;
  var latS = coordS.lat();
  var lngS = coordS.lng();
  document.getElementById('latlng').value = latS+", "+lngS;
  document.getElementById('placeId').value = place.place_id;

  if (geoCode){//on distingue en fonction du fait que l'adresse probient de la geoloc ou de l'autocompletion
    positionS(geoCode);
  }else {
    positionS();
  }

}

//Function pour center map sur adresse donnée + afficher une fenetre map
function positionS(geoCode){
  //on récupère un objet avec toute les informations de l'autocomplete
  if (geoCode){//on distingue en fonction du fait que l'adresse probient de la geoloc ou de l'autocompletion
    var place = geoCode;
  }else {
    var place = autocomplete.getPlace();
  }
  //on créé un obj fenetre de map
  var infowindow = new google.maps.InfoWindow();

  //on recentre la carte (=en refaire une)
  var map = new google.maps.Map(mapcanvas);
  var marker = new google.maps.Marker({
      map: map,
      icon: "img/maker.svg",
      animation:google.maps.Animation.DROP,
    });
  infowindow.open(map, marker);
  //on ecoute le marker et si click on affiche info
  marker.addListener('click', function() {
      infowindow.open(map, marker);
    });

  //si les infos géometrique du ne sont pas fournis
  if (!place.geometry) {
    return;
  }
  if (place.geometry.viewport) {
    map.fitBounds(place.geometry.viewport);
    map.setCenter(place.geometry.location);
    map.setZoom(17);
  } else {//sinon on centre la map sur ça;
    map.setCenter(place.geometry.location);
    map.setZoom(17);
  }

  // Set the position of the marker using the place ID and location.
  marker.setPlace({
    placeId: place.place_id,
    location: place.geometry.location
  });
  //info dans fenetre
  infowindow.setContent('<div><strong> Nom : </strong>' +  place.name+ '<br><div><strong> Adresse : </strong>' + place.formatted_address + '<br></div>');
}

// [START region_geolocation]
// Bias the autocomplete object to the user's geographical location,as supplied by the browser's 'navigator.geolocation' object.
function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
      var geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };
      var circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });
      autocomplete.setBounds(circle.getBounds());
    });
  }
}
// [END region_geolocation]

//Bouton se geolocaliser
function Geolocalisation(){
  function showPosition(position) {
    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
    var TabLatlng = {lat: latlng.lat(), lng: latlng.lng()};
    var geocoder = new google.maps.Geocoder;
    geocoder.geocode({'location': TabLatlng}, function(results, status) {
      if (status === 'OK') {
        if (results[1]) {//tab retourné par geocode
          document.getElementById('autocomplete').value = results[1].formatted_address;
          fillInAddress(results[1]);
        } else {
          window.alert('No results found');
        }
      } else {
        window.alert('Geocoder failed due to: ' + status);
      }
    });
  }

  function showError(error) {
    switch(error.code) {
        case error.PERMISSION_DENIED:
            x.innerHTML = "User denied the request for Geolocation.Merci d'activer votre Geolocalisation."
            break;
        case error.POSITION_UNAVAILABLE:
            x.innerHTML = "Location information is unavailable."
            break;
        case error.TIMEOUT:
            x.innerHTML = "The request to get user location timed out."
            break;
        case error.UNKNOWN_ERROR:
            x.innerHTML = "An unknown error occurred."
            break;
    }
  }

  if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(showPosition, showError);
  } else {
      x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

/**********Fonction pour les icones des types de problèmes******/
function change(nTypeS) {
  select = document.getElementById("selectType");
  descriptionS = document.getElementById("descriptionS");
  longA = document.getElementsByClassName("imgType").length;//pour le nombre de for
  longB = document.getElementsByClassName("imgTypeActif").length;//idem mais en prenant le new Classname
  long = longB+longA;//nombre d'image de types de pb
  for (var i=1; i<=long; i++){
    valeur = document.getElementById("typeS"+i);
    if (i === nTypeS){
      //on assigne le nom de l'élément comme valeur à l'input caché;
      valeur.className ="imgType";
      select.value = valeur.id;
      descriptionS.value = valeur.alt;
      //on met en surbrilance le choix
      valeur.className =valeur.className+"Actif";

    } else {
      valeur.className ="imgType";

    }
  }
}
/****On désactive la touche entrée pour le form*****/
document.addEventListener("keydown", function(event) {
if (event.keyCode == 13) {
event.preventDefault();
return false;
}
}, true);

/****On désactive le double clik pour les img A TROUVER*****/


/****FIN DU SCRIPT************/
</script>
