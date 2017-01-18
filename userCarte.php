<?php
header('content-type: text/html; charset=utf-8');

//fonction qui recherche toute seule la classe à requerir
function chargerClass($classe)
{
	require $classe.'.php';
}
spl_autoload_register('chargerClass');

//On a créé des sessions et pour que ça fonctionne, il faut en déclarer l'ouverture.
session_start();
if (isset($_GET['deconnexion']))
{
  require 'deconn.php';
}

//******Connect BD********
require 'connData.php';
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

/***********traitement sur la page index*/

  $manageU = new UtilisateurManager($bdd);
	//A voir avec Dylan si on garde session comme ça
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
    <header>
			<div class="navFix">
				<!-- Nav Bar + Side -->
	      <!-- ATTENTION headerNav different pour chaque page pour selection du bon onglet" -->
	      <?php include 'headerNavUserCarte.php'; ?>
			</div>
    </header>
    <main>
      <!-- Partie centrale en dessous de navBar-->
      <div class="mainUserCarte">
        <div class="mainLeft" id="listSignal">
          <!-- Intégration des signalements à gauche de la carte + effet tournant -->
							<?php
							$siMa = new SignalementManager($bdd);
							$nSignal = $siMa->count();
							$i=0;//compteur du nombre de signalements
							$id=0;// compteur des id à augmenter de temps en temps :))
							while ($i<$nSignal){
								$siExist = $siMa->exists($id);
								if(!$siExist){
									//	ici on pourrait regarder de temps en temps pour faire partir le compteur
									$id++;
								}else{
									$si = $siMa->getSignal($id);
									echo  '<div class="msgsignal">
											 <p>'.$si->getTypeS().' : </p>
											 <p>'.$si->getDescriptionS().'</p>
											 <p> A '.$si->getVilleS().'</p>
											 <p> Le '.$si->getDateS().'</p>
										 </div> <br>';
									$i++;
									$id++;
								}
							}
							?>
				</div>
        <div class= "mapcanvas"  id="mapcanvas">
					<!-- Intégration de la carte + Geolocation + placement maker -->
          <!-- Laisser ce script à l'exterieur du script de recupération MAP-->
					<script async defer type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc"></script>
          <script>
            // Geolocation + Marker
            //Récuperation de la Div "mapcanvas" du html
            var mapcanvas = document.getElementById("mapcanvas");
						var x = document.getElementById("mapcanvas");//utilisée pour l'affichage des erreurs uniquement
            //Geolocation sur map
            function showPosition(position) {
              //récup lat et lng dans une var
              var latlng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
              // type de map afficher + zoom et placement
              var myOptions = {
                zoom: 12
                , center: latlng
                , mapTypeId: google.maps.MapTypeId.ROADMAP
              };
              // generation de la map
              var map = new google.maps.Map(mapcanvas, myOptions);
              //MAJ de la map en focntion des new Latlng
              var majMap = map.panTo(new google.maps.LatLng(position.coords.latitude, position.coords.longitude));
              // création Maker et son placement
              var marker = new google.maps.Marker({
                position: latlng
                , map: map
                , draggable: true
                , icon: "img/maker.svg"
                , animation: google.maps.Animation.BOUNCE
              });
              // Event de click sur marker de position
              google.maps.event.addListener(marker, 'click', function () {
                alert("Par là quoi, à +/- "+position.coords.accuracy+" m à la ronde :))"); //message d'alerte
              });
							//autre makerS
							//tableau contenant tous les marqueurs que nous créerons
							var tabMarqueurs = new Array();
							//notez la présence de l'argument "event" entre les parenthèses de "function()"
							google.maps.event.addListener(map, 'click', function(event) {
									tabMarqueurs.push(new google.maps.Marker({
											position: event.latLng,//coordonnée de la position du clic sur la carte
											map: map//la carte sur laquelle le marqueur doit être affiché
									}));
							});
            }//fin de showposition

            // Error si carte impossible à afficher
            function showError(error) {
              switch (error.code) {
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

            //Si géolocalisation supporter par navigateur alors appelle de fonction
            if (navigator.geolocation) {
              navigator.geolocation.getCurrentPosition(showPosition, showError);
            }
            else {
              x.innerHTML = "Geolocation is not supported by this browser.";
            }
          </script>
				</div>
      </div>
    </main>
    <?php include( 'footer.php');?>
  </body>

</html>
