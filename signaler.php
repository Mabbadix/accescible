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
						<input class="unSignalement" id="autocomplete" placeholder="Entrer une adresse" onFocus="geolocate()" type="text"></input>
						<br/>
						<table>
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
		          <td class="wideField">
								<input class="unSignalement" id="postal_code" name="cpS" disabled="true" placeholder="CP"></input>
							</td>
							<label for="villeS"></label>
		          <td class="wideField">
								<input class="unSignalement" id="locality" name="villeS" disabled="true" placeholder="Ville"></input>
							</td>
			        </tr>
			        <tr>
								<label for="regionS"></label>
			          <td class="slimField">
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
						<input class="unSignalement" id="geocodeReverse" type="button" value="Se géolocaliser"></input><!--avt onclick="geoCoding();"-->
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


		/*Displays an address form, using the autocomplete feature
    of the Google Places API to help users fill in the information.*/
		//Variable we needs
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

		function initAutocomplete() {

		      //First map on the page
		      var mapcanvas = document.getElementById("mapcanvas");
		      var myOptions = {
		          zoom: 8,
		          center: {lat: -34.397, lng: 150.644},
		          };
		      var map = new google.maps.Map(mapcanvas, myOptions);


		      // Create the autocomplete object, restricting the search to geographical
		      // location types.
		      autocomplete = new google.maps.places.Autocomplete((input),
		          {types: ['geocode'], 'componentRestrictions':{country:'FR'}});

		        // When the user selects an address from the dropdown, populate the address fields in the form.
		        autocomplete.addListener('place_changed', fillInAddress);
		      }

		    // [START region_fillform]
		    function fillInAddress() {
		      // Get the place details from the autocomplete object (une fois le autocomplete fait, l'API retourne un objet avec plein d'infos :)).
		      var place = autocomplete.getPlace();

		      //on complete le componentForm
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
					//on rappelle les var ici sinon inaccessible pour créer une nouvelle qu'on va utilisé pour le geocodage
		      var mapcanvas = document.getElementById("mapcanvas");
		      var myOptions = {
		          zoom: 15
		          };
		      var map = new google.maps.Map(mapcanvas, myOptions);
		      var geocoder = new google.maps.Geocoder();
		      geocodeAddress(geocoder, map);
		    }

		    function geocodeAddress(geocoder, resultsMap) {
		      var addresse = document.getElementById('autocomplete').value;

				  geocoder.geocode({'address': addresse, 'componentRestrictions':{country:'FR'} }, function(results, status)
					{
				    if (status === google.maps.GeocoderStatus.OK)
						{
				      resultsMap.setCenter(results[0].geometry.location);
				      var marker = new google.maps.Marker({
				        map: resultsMap,
				        position: results[0].geometry.location,
								animation:google.maps.Animation.BOUNCE
				      });
			    	} else {
			      alert('Nous n\'avons pas pu localiser l\'adresse, merci de renseigner correctement les champs demandés.  ' + status);
			    	}
			  	});
				}
		    // [START region_geolocation]
		    // Bias the autocomplete object to the user's geographical location,
		    // as supplied by the browser's 'navigator.geolocation' object.
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
	  </script>

			<!--
/*
//original

			var mapcanvas = document.getElementById("mapcanvas");

			function showPosition(position) {
				var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);

				var myOptions = {
					zoom: 15,
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
					animation:google.maps.Animation.BOUNCE,
					title:"Vous êtes ici ! (à +/- "+position.coords.accuracy+" mètres à la ronde)"

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
				function geoCoding (){
					navigator.geolocation.getCurrentPosition(showPosition, showError);
					alert ("je n'y arrive pas");
				}*/
			</script>-->
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc&signed_in=true&libraries=places&callback=initAutocomplete" async defer>
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
