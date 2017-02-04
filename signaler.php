<?php
session_start();

/** Importation de l'autoloader **/

require 'class/Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

if (isset($_GET['deconnexion']))
{
  require 'deconn.php';
}

//******Connect BD********

require 'connData.php';

$manageU = new UtilisateurManager($bdd);

if (isset($_SESSION['emailU'])){
?>



  <!DOCTYPE html>
  <html lang="fr">

  <head>
    <?php
	$type = "utilisateur";
	include 'head.php';
	?>
      <title>Acces'Cible-Signalement</title>
  </head>

  <body>
    <div class="site-container">
      <?php include'header.php';?>
    <div class="site-pusher">
  <div class="site-content">
    <div class="container">
      <!--CENTER-->
      <div class="mainUserCarte">
        <div class="mainLeft">
          <?php	include 'signalerTraitement.php';
				if($etat=="ok"){
				  echo '<script type="text/javascript"> window.setTimeout("location=(\'signalerSlideShow.php\');",10) </script>';
				}?>
            <form class="unSignalementForm" name="signalement" method="post" enctype="multipart/form-data" action=#>
              <fieldset name="localiser">
                <legend>Localiser</legend>
                <?php if($etat=="localiser") {
								echo'<div id="notif" class="warning"> <h2>Merci de localiser le problème</h2></div>';}?>
						<br>
						<table id="address1">
						<input class="unSignalementField" type="text" id="autocomplete" placeholder="Adresse complète, lieu, commerce etc." onFocus="initAutocomplete(), geolocate()" ></input>
						<tr >
							<label for="adresseS"></label>
						  <td class="slimField1">
								<input class="unSignalementField" id="street_number" name="numero" disabled="true" placeholder="n°" type="hidden"></input>
							</td>
		          <td class="wideField" >
								<input class="unSignalementField" id="route" name="adresseS" disabled="true" placeholder="type de voie et son intitulé" type="hidden"></input>
							</td>
		        </tr>
		        <tr>
							<label for="cpS"></label>
		          <td class="slimField1">
								<input class="unSignalementField" id="postal_code" name="cpS" disabled="true" placeholder="CP" type="hidden"></input>
							</td>
							<label for="villeS"></label>
		          <td class="wideField">
								<input class="unSignalementField" id="locality" name="villeS" disabled="true" placeholder="Ville" type="hidden"></input>
							</td>
			      </tr>
						</table>
						<table>
			        <tr>
								<label for="regionS"></label>
								<td class="slimField1">
									<input class="unSignalementField1" type="hidden"></input>
								</td>
			          <td class="wideField">
									<input class="unSignalementField1" id="administrative_area_level_1" name="regionS"  type="hidden" value="nc"></input>
								</td>
							</tr>
							<tr>
								<label for="paysS"></label>
								<td class="slimField1">
									<input class="unSignalementField1" type="hidden"></input>
								</td>
			          <td class="wideField">
									<input class="unSignalementField1" id="country" name="paysS" type="hidden" value="France"></input>
								</td>
			        </tr>
							<tr>
								<label for="latlgn"></label>
								<td class="slimField">
									<input class="unSignalementField1" id="latlng" name="latlngS"  type="hidden" value="0"></input>
								</td>
								<td class="slimField">
									<input class="unSignalementField1" id="lat" name="lat"  type="hidden" value="0"></input>
								</td>
								<td class="slimField">
									<input class="unSignalementField1" id="lng" name="lng"  type="hidden" value="0"></input>
								</td>
								<label for="placeId"></label>
								<td class="slimField">
									<input class="unSignalementField1" id="placeId" name="placeIdS" type="hidden" value="0"></input>
								</td>
							</tr>
              <input class="unSignalementField" id="rechargePage" name="rechargePage" type="hidden" onclick="location.reload()" value="Essayer la géoloc"></input>
	      		</table>
						<label for="Geolocalisation"></label>
						<input type ="button" class="unSignalementGeoloc" id="geocodeReverse"  onFocus="Geolocalisation()"></input>
					</fieldset>
					<fieldset id="descriptionSFied" name="decrire">
						<legend>Décrire</legend>
						<?php if($etat=="decrire"){
								echo '<div id="notif" class="warning"> <h2>Merci de décrire le problème</h2></div>';
						}?>
                  <label for="typeS"></label>
                  <input class="typeS" type="hidden" name="typeS" id="selectType" required></input>
                  <img class="imgType" alt="Place handicapée absente, occupée et/ou inadéquate." id="typeS1" src="img/typeS1.png " onclick="change(1)"></img>
                  <img class="imgType" alt="Absence de signal sonore, tactile ou lumineux." id="typeS2" src="img/typeS2.png" onclick="change(2)"></img>
                  <img class="imgType" alt="Passage inadapté et/ou encombré." id="typeS3" src="img/typeS3.png" onclick="change(3)"></img>
                  <br>
                  <br>
                  <img type="image" class="imgType" alt="Problème d'accès en hauteur(rampe, ascenseur...)." id="typeS4" src="img/typeS4.png" onclick="change(4)"></img>
                  <img type="image" class="imgType" alt="Sanitaires absents et/ou non adaptés." id="typeS5" src="img/typeS5.png" onclick="change(5)"></img>
                  <img type="image" class="imgType" id="typeS6" src="img/typeS6.png" alt="Problème autre." onclick="change(6)"></img>
                  <br>
                  <br>
                  <label for="descriptionS"></label>
                  <textarea class="descriptionS" name="descriptionS" id="descriptionS" rows="3" cols="29" placeholder="Description du problème en 100 caractères maximum"></textarea>
              </fieldset>
              <fieldset name="photoUploads">
                <legend>Photo</legend>
                <?php
						switch ($etat) {
							case "format":
								echo '<div id="notif" class="error"> <h2>Le format du fichier n\'est pas accepté. Seuls sont acceptés,les fichiers en .jpg, .jpeg, .gif, .png, .svg. Merci de recommencer.</h2></div>';
								break;
							case "taille":
								echo '<div id="notif" class="error"> <h2>La photo est trop volumineuse. Merci de recommencer.</h2></div>';
								break;
							case "autre":
								echo '<div id="notif" class="error"> <h2>Erreur dinconnue lors du chargement de la photo. Merci de recommencer.</h2></div>';
								break;
						}?>
						<input type="hidden" name="MAX_FILE_SIZE" value="10000000">
						<label id="fileContainer">
							<img src="img/telecharge.jpeg" alt="télécharge" id="putPhotoS"/>
							<input class="incPhotoS" id="incPhotoS" type="file" name="photoS"/>
						</label>
					</fieldset>
					<fieldset name="valider">
						<legend>Valider</legend>
						<label for="signaler"></label><br/>
						<button class="spin button--circle" name="signaler" id="signaler" ><img id="doigt" src="img/doigt.svg"></img></button>
            </fieldset>
        </form>

		</div>
		<div id="mapcanvas"></div>
		<?php	include 'signalerGeoloc&Autre.js';?>
		</div>
  <?php include 'footer.php';?>
  </div>
  </div>
<div class="site-cache" id="site-cache"></div>
  </div>
  </div>
</body>
<script src="js/app.js"></script>
 <script>
  var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

  var hamburgers = document.querySelectorAll(".hamburger");
  if (hamburgers.length > 0) {
    forEach(hamburgers, function(hamburger) {
      hamburger.addEventListener("click", function() {
        this.classList.toggle("is-active");
      }, false);
    });
  }
</script>
</html>
<?php
// ATTENTION FERMETURE DE LA SESSION SI ouverture
}else {

	header("location: index.php");

}

 ?>
