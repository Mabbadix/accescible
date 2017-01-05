<?php
//ouverture de session
header( 'content-type: text/html; charset=utf-8' );
session_start();
require("connData.php");
//Si la session est ouvert alors code s'execute sinon voir fin page
if (isset($_SESSION['emailU'])){
?>

<!DOCTYPE html>
<html lang="fr">
	<head>
    <?php include ("headUtilisateur.php"); ?>


		<title>Acces'Cible-Signalement</title>
	</head>

	<body>
  <header><!-- NAVBAR -->
		<?php include 'headerNavSignaler.php'; ?>
  </header>
  <main><!--CENTER-->
		<div class="mainUserCarte">
			<div class="mainLeft">
        <form class="unSignalement" name ="signalement" method = "post"
				 enctype="multipart/form-data"><center>
					<fieldset name="localiser">
						<legend>Localiser</legend>

						<table id="address1">
							<tr id="locationField">
								<input class="unSignalement" id="autocomplete" placeholder="Adresse, lieu, commerce ou autre" onFocus="initAutocomplete()" type="text"></input>
							</tr>
		        <tr>
							<label for="adresseS"></label>
		          <td class="slimField">
								<input class="unSignalement" id="street_number" name="numéro" disabled="true" placeholder="n°"></input>
							</td>
		          <td class="wideField" >
								<input class="unSignalement" id="route" name="adresseS" disabled="true" placeholder="type de voie et son intitulé"></input>
							</td>
		        </tr>
		        <tr>
							<label for="cpS"></label>
		          <td class="slimField">
								<input class="unSignalement" id="postal_code" name="cpS" disabled="true" placeholder="CP"></input>
							</td>
							<label for="villeS"></label>
		          <td class="wideField">
								<input class="unSignalement" id="locality" name="villeS" disabled="true" placeholder="Ville"></input>
							</td>
			        </tr>
			        <tr>
								<label for="regionS"></label>
			          <td class="wideField">
									<input class="unSignalement" id="administrative_area_level_1" name="regionS" disabled="true" placeholder="Région"></input>
								</td>
								<label for="paysS"></label>
			          <td class="wideField">
									<input class="unSignalement" id="country" name="paysS" disabled="true" placeholder="Pays"></input>
								</td>
			        </tr>
	      		</table>
						OU<br/>
						<label for="geocodeReverse"></label>
						<input class="unSignalement" id="geocodeReverse" type="button" value="Se géolocaliser" onFocus="Geolocalisation()"></input><!--avt onclick="geoCoding();"-->
					</fieldset>
					<fieldset name="decrire">
						<legend>Décrire</legend>
							<label for="typeS"></label> <select
							class="typeS" name="typeS" id="typesS"required >
								<option value=0 name="typeS1" class="typeS" id="typesS">
									Choisir dans la liste_ _</option>
								<option name="typeS2" value="place handicapée">
									Pas de place handicapée</option>
								<option name="typeS3" value="signal sonore ou lumineux">
									Pas de signal sonore ou lumineux</option>
								<option name="typeS4" value="Trottoir">
									Trottoir inadapté ou encombré</option>
								<option name="typeS5" value="accès en hauteur">
									Pas d'accès en hauteur</option>
									<option name="typeS6" value="sanitaires non adaptés">
									Sanitaires pas adaptés</option>
							</select></br></br>
							<label for="descriptionS"></label>
							<textarea name="descriptionS" id="descriptionS" rows="5" cols="28"
							placeholder="Faire un petite description du problème en 140 caractères maximum"></textarea>
					</fieldset>
					<fieldset name="photoUploads">
						<legend>Photo</legend>
						<input type="hidden" name="MAX_FILE_SIZE" value="1000000">
						<input type="file" name="photoS">
					</fieldset>
					<fieldset name="valider">
						<legend>Valider</legend>
						<label for="signaler"></label><br/><input  class="unSignalement"
						type="submit" name="signaler" value="signaler" id="signaler" formaction = "unSignalement.php">
            </fieldset>
        </form>
		</div>

		<div id="mapcanvas"></div>

		<script>
		/******VARIABLES COMMUNES********************/

		/*Var pour map*/
		var mapcanvas = document.getElementById("mapcanvas");
		var x = document.getElementById("mapcanvas");//utilisée pour l'affichage des erreurs uniquement


		/*Variable pour l'autocomplete et geocode*/
    var autocomplete;

    //this var use same name of id component and google array result after autocomplete (=address_components)
    var componentForm = {
      street_number: 'short_name',
      route: 'long_name',
      locality: 'long_name',
      administrative_area_level_1: 'short_name',
      country: 'long_name',
      postal_code: 'short_name'
    };

    var input = /** @type {!HTMLInputElement} */ (document.getElementById('autocomplete'));


		/***************MAPS AFFICHER DE BASE*********************/

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

			//configuration du marker
		  var marker = new google.maps.Marker({
		      position: latlng,
		      map: map,
		      draggable:true,
		      icon: "img/maker.svg",
		      animation:google.maps.Animation.BOUNCE,
		  });

			//event sur le marker
		  google.maps.event.addListener(marker, 'click', function() {
		  alert("Par là quoi, à +/- "+position.coords.accuracy+" m à la ronde :))");//message d'alerte
		  });
		}

		// Gestion des erreurs en cas de non-affichage de la map
	  function showError(error) {
	    switch(error.code) {
	        case error.PERMISSION_DENIED:
	            x.innerHTML = "User denied the request for Geolocation."
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

			//récupération infos position + lancement de showPosition
        navigator.geolocation.getCurrentPosition(showPosition, showError);
	  } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
	  }

/***************Autocpmpletation + Geocodage *********************/
/*Displays an address form, using the autocomplete feature
of the Google Places API to help users fill in the information.*/

		function initAutocomplete() {
			// this function bias autocompletation and put a bounds limits, only France country, cf. infra;
			geolocate();
      // Create the autocomplete object, restricting the search to geographical location types.
      autocomplete = new google.maps.places.Autocomplete((input),
          {types: ['geocode'], 'componentRestrictions':{country:'FR'}});

        // Listen "autocomplete" objet. When the user selects an address from the dropdown (=place_changed), populate the address fields in the form(=fillInAddress).
        autocomplete.addListener('place_changed', fillInAddress);
      }

    // [START region_fillform]
    function fillInAddress() {
      // Get the place details from the autocomplete object (une fois le autocomplete fait, l'API retourne un objet avec plein d'infos).
      var place = autocomplete.getPlace();

      //ici on rend dispo les component du form (voir si on garde)
      /*for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
      }*/

      // Get each component of the address from the place details and fill the corresponding field on the form.
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById(addressType).value = val;
        }
      }

			//une fois l'autocomplete fait, on fait le géocodage

			//on rappelle les var ici sinon inaccessible pour créer une nouvelle qu'on va utilisé pour le geocodage
			var mapcanvas = document.getElementById("mapcanvas");
      var myOptions = {
          zoom: 17
          };
      var map = new google.maps.Map(mapcanvas, myOptions);

			//on crée un objet de géocodage;
      var geocoder = new google.maps.Geocoder();

			//on appelle la fonction de géocodage et on lui passe l'objet geocodé et un carte;
      geocodeAddress(geocoder, map);
    }

		//fonction pour Geocoder = localiser un point sur carte en fonction d'une adresse;
    function geocodeAddress(geocoder, resultsMap) {
      var addresse = document.getElementById('autocomplete').value;

			//on géocode l'objet geocoder avec les paramètre requis;
		  geocoder.geocode({'address': addresse, 'componentRestrictions':{country:'FR'} }, function(results, status)//results et status sont des retours de l'API
			{
		    if (status === google.maps.GeocoderStatus.OK)
				{
		      resultsMap.setCenter(results[0].geometry.location);
		      var marker = new google.maps.Marker({
		        map: resultsMap,
		        position: results[0].geometry.location,
						icon: "img/maker.svg",
		      });
	    	} else {
	      alert('Nous n\'avons pas pu localiser l\'adresse, merci de renseigner correctement les champs demandés.  ' + status);
	    	}
	  	});
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
	  var mapcanvas = document.getElementById("mapcanvas");

	  function showPosition(position) {
	    var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

	    var myOptions = {
	      zoom: 17,
	      center: latlng,
	      mapTypeId: google.maps.MapTypeId.ROADMAP
	    };
	  var map = new google.maps.Map(mapcanvas, myOptions);
	  var majMap = map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
	  var marker = new google.maps.Marker({
	      position: latlng,
	      map: map,
	      draggable:true,
	      icon: "img/maker.svg",
	    });
	  google.maps.event.addListener(marker, 'click', function() {
	  alert("Le marqueur a été cliqué.");//message d'alerte
	  });
	}
	  function showError(error) {
	    switch(error.code) {
	        case error.PERMISSION_DENIED:
	            x.innerHTML = "User denied the request for Geolocation."
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
	  </script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc&signed_in=true&libraries=places" async defer>
	    // async defer = pas synchronization page ce qui permets de moins attendre
			</script>
  </div>
</main>
  <footer>
    <p>Nos partenaires</p>
  </footer>
  </body>
</html>
<?php
// ATTENTION FERMETURE DE LA SESSION SI ouverture
}else {

	header("location: index.php");

}

 ?>
