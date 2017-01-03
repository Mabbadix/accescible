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
							<label for="adresseS"></label><input class="unSignalement"id="adresseS"
							type="text" name="adresseS" placeholder="adresse"><br/>
		          <label for="cpS"></label><input class="unSignalement" id="cpS"
							 type="text" name="cpS" placeholder="code postal" maxlength=5 ><br/>
		          <label for="villeS"></label><input class="unSignalement" id="villeS"
							type="text" name="villeS" placeholder="ville" ><br/>
							<label for="geocode"></label><input class="unSignalement" id="geocode" type="button" value="valider"><br/>OU
							<br/>
							<label for="geocodeReverse"></label><input class="unSignalement" id="geocodeReverse" type="button" value="Se géolocaliser"><!--avt onclick="geoCoding();"-->
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
		<div id="mapcanvas">
			<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc&signed_in=true&callback=initMap">//signed = mettre icon comptegoogle du créateur map + callback = appel de focntion a renvoyer;
	    </script>
			<script>
			function initMap()
			{
				var mapcanvas = document.getElementById("mapcanvas");
				var myOptions = {
						zoom: 10,
						center: {lat: -34.397, lng: 150.644},
						};
				var map = new google.maps.Map(mapcanvas, myOptions);
			  var geocoder = new google.maps.Geocoder();

			  document.getElementById('geocode').addEventListener('click', function() {
			    geocodeAddress(geocoder, map);
			  });
			}

			function geocodeAddress(geocoder, resultsMap) {
			  var addresse = document.getElementById('adresseS').value+" "+document.getElementById('cpS').value+" "+ document.getElementById('villeS').value;
			  geocoder.geocode({'address': addresse}, function(results, status)
				{
			    if (status === google.maps.GeocoderStatus.OK)
					{
			      resultsMap.setCenter(results[0].geometry.location);
			      var marker = new google.maps.Marker({
			        map: resultsMap,
			        position: results[0].geometry.location,
							icon: "img/maker.svg",
							animation:google.maps.Animation.BOUNCE
			      });
		    	} else {
		      alert('Nous n\'avons pas pu localiser l\'adresse, merci de renseigner correctement les champs demandés.  ' + status);
		    	}
		  	});
			}
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
			</script>
    </div>
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
