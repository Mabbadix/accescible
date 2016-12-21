<?php
//ouverture de session
	session_start();
	require 'connData.php';
	if (isset($_SESSION['emailU'])){

?>
<!DOCTYPE html>
<html lang="fr">
	<head>
    <!-- integration de toutes les metas et autres link
				ATTENTION link styleUser.css different du "style.css" -->
		<?php include 'headUtilisateur.php'; ?>
		<title>Acces'Cible-Carte_Utilisateur</title>
	</head>

	<body>
		<header> <!-- Nav Bar + Side -->
			<!-- ATTENTION headerNav different pour chaque page pour selection du bon onglet" -->
			<?php include 'headerNavUserCarte.php'; ?>
		</header>
		<main><!-- Partie centrale en dessous de navBar-->
			<div class="mainUserCarte">
				<div class= "mainLeft" id="listSignal"><!-- Intégration des signalements à gauche de la carte  -->
					<?php
						$reqs = 'SELECT typeS, descriptionS, villeS, dateS FROM signalements';
						foreach ($bdd->query($reqs) as $row) {
							echo  '<div class="msgsignal">
							       <p>'.$row['typeS'].' : </p>
	                   <p>'.$row['descriptionS'].'</p>
	                   <p> A '.$row['villeS'].'</p>
										 <p> Le '.$row['dateS'].'</p>
	                   </div><br>';
						}
					?>
				</div>
				<div id="mapcanvas"> <!-- Intégration de la carte + Geolocation + placement maker -->
							<!-- Laisser ce script à l'exterieur du script de recupération MAP-->
					<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
					<script> // Geolocation + Marker
							//Récuperation de la Div "mapcanvas" du html
						var mapcanvas = document.getElementById("mapcanvas");
							//Geolocation sur map
						function showPosition(position) {
								//récup lat et lng dans une var
							var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
								// type de map afficher + zoom et placement
							var myOptions = {
								zoom: 15,
								center: latlng,
								mapTypeId: google.maps.MapTypeId.ROADMAP
							};
								// generation de la map
							var map = new google.maps.Map(mapcanvas, myOptions);
								//MAJ de la map en focntion des new Latlng
							var majMap = map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
								// création Maker et son placement
							var marker = new google.maps.Marker({
								position: latlng,
								map: map,
								draggable:true,
								icon: "img/maker.svg",
								animation:google.maps.Animation.BOUNCE,
								title:"Vous êtes ici ! (à +/- "+position.coords.accuracy+" mètres à la ronde)"
							});
								// Event de click sur marker de position
							google.maps.event.addListener(marker, 'click', function() {
								alert("Le marqueur a été cliqué.");//message d'alerte
							});
						}
							// Error si carte impossible à afficher
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
							// Test si géolocalisation supporter par navigateur
						if (navigator.geolocation) {
							navigator.geolocation.getCurrentPosition(showPosition, showError);
						} else {
							x.innerHTML = "Geolocation is not supported by this browser.";
						}
					</script>
				</div>
			</div>
		</main>
		<footer>
		<!-- Pied de page avec Partenaires et infos legal -->
			<p>Nos partenaires<p>

		</footer>
	</body>
</html>
<?php
// ATTENTION FERMETURE DE LA SESSION SI ouverture
}else {

	header("location: index.php");

}

 ?>
