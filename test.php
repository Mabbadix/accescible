<!DOCTYPE html>
<html>
  <head>
    <title>Place Autocomplete Address Form</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <style>
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #map {
        height: 100%;
      }
    </style>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500">
    <style>
      #locationField, #controls {
        position: relative;
        width: 480px;
      }
      #autocomplete {
        position: absolute;
        top: 0px;
        left: 0px;
        width: 99%;
      }
      .label {
        text-align: right;
        font-weight: bold;
        width: 100px;
        color: #303030;
      }
      #address {
        border: 1px solid #000090;
        background-color: #f0f0ff;
        width: 480px;
        padding-right: 2px;
      }
      #address td {
        font-size: 10pt;
      }
      .field {
        width: 99%;
      }
      .slimField {
        width: 80px;
      }
      .wideField {
        width: 200px;
      }
      #locationField {
        height: 20px;
        margin-bottom: 2px;
      }
    </style>
  </head>

  <body>
  <div id = "form">
    <div id="locationField">
      <input id="autocomplete" placeholder="Enter your address"
             onFocus="geolocate()" type="text"></input>
    </div>
    <div id="address">
      <table>
        <tr>
          <td><input class="field" id="street_number" disabled="true" placeholder="n°"></input></td>
          <td class="wideField" colspan="3" ><input class="field" id="route" disabled="true" placeholder="type de voie et son intitulé"></input></td>
        </tr>
        <tr>
          <td class="wideField"><input class="field" id="postal_code" disabled="true" placeholder="CP"> </input></td>
          <td class="wideField"><input class="field" id="locality" disabled="true" placeholder="Ville"></input></td>
        </tr>
        <tr>
          <td class="slimField"><input class="field" id="administrative_area_level_1" disabled="true" placeholder="Région"></input></td>
          <td class="wideField" colspan="3"><input class="field" id="country" disabled="true" placeholder="Pays"></input></td>
        </tr>
      </table>
    </div>
  </div>
    <div id="text"></div>
  <div id="map"></div>
  <script>//spécial map
  // This example requires the Places library. Include the libraries=places
     // parameter when you first load the API. For example:
     // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">



  </script>

    <script>
    /*Displays an address form, using the autocomplete feature
    of the Google Places API to help users fill in the information.*/

    //Variable we needs

    var placeSearch, autocomplete;
    var autocompletOk;

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
    var text = document.getElementById('text');
    // Create the autocomplete object, restricting the search to geographical
    // location types.




    function initAutocomplete() {

      var mapcanvas = document.getElementById("map");
      var myOptions = {
          zoom: 8,
          center: {lat: -34.397, lng: 150.644},
          };
      var map = new google.maps.Map(mapcanvas, myOptions);



      autocomplete = new google.maps.places.Autocomplete((input),
          {types: ['geocode'], 'componentRestrictions':{country:'FR'}});


        // When the user selects an address from the dropdown, populate the address fields in the form.
        autocomplete.addListener('place_changed', fillInAddress);
      }

    // [START region_fillform]
    function fillInAddress() {
      // Get the place details from the autocomplete object.


      var place = autocomplete.getPlace();


      //ici on fait de l'autocomplete
      for (var component in componentForm) {
        document.getElementById(component).value = '';
        document.getElementById(component).disabled = false;
      }

      // Get each component of the address from the place details
      // and fill the corresponding field on the form.
      for (var i = 0; i < place.address_components.length; i++) {
        var addressType = place.address_components[i].types[0];
        if (componentForm[addressType]) {
          var val = place.address_components[i][componentForm[addressType]];
          document.getElementById(addressType).value = val;
        }
      }
//on rappelle les var ici sinon inaccessible
      var mapcanvas = document.getElementById("map");
      var myOptions = {
          zoom: 15
          };
      var map = new google.maps.Map(mapcanvas, myOptions);
      var geocoder = new google.maps.Geocoder();
      geocodeAddress(geocoder, map);
    }

    function geocodeAddress(geocoder, resultsMap) {
      text.innerHTML = "<p> <br/> <strong>Le son est good</strong> <br/> Pour répondre à notre problème nous allons utiliser l’acoustique.</p>";
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

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc&signed_in=true&libraries=places&callback=initAutocomplete" async defer>
    </script><!--Attention AutocompletionKey-->



  </body>
</html>
