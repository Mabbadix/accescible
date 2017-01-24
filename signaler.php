<?php
//ouverture de session
header( 'content-type: text/html; charset=utf-8' );
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
$manageU = new UtilisateurManager($bdd);
if (isset($_SESSION['emailU'])){
?>



<!DOCTYPE html>
<html lang="fr">
	<head>
    <?php	include ("headUtilisateur.php"); ?>
		<title>Acces'Cible-Signalement</title>
	</head>

	<body>
  <header><!-- NAVBAR -->
		<div class = "navFix">
		<?php
		$nav_en_cours = 'signaler';
		include 'headerNavUserCarte.php'; ?>
	</div>
  </header>

  <main><!--CENTER-->
		<div class="mainUserCarte">
			<div class="mainLeft">
				<?php	include( 'unSignalement.php');
				if($etat=="ok"){
					header('Location: signalementInfo.php');
				}?>
        <form class="unSignalementForm" name ="signalement" method = "post"
				 enctype="multipart/form-data" action=#>
					<fieldset name="localiser" >
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
									<input class="unSignalementField" type="hidden"></input>
								</td>
			          <td class="wideField">
									<input class="unSignalementField" id="administrative_area_level_1" name="regionS" disabled="true" placeholder="Région" type="hidden"></input>
								</td>
							</tr>
							<tr>
								<label for="paysS"></label>
								<td class="slimField1">
									<input class="unSignalementField" type="hidden"></input>
								</td>
			          <td class="wideField">
									<input class="unSignalementField" id="country" name="paysS" disabled="true" placeholder="Pays" type="hidden"></input>
								</td>
			        </tr>
							<tr>
								<label for="latlgn"></label>
								<td class="slimField">
									<input class="unSignalementField" id="latlng" name="latlngS"  type="hidden"></input>
								</td>
								<label for="placeId"></label>
								<td class="slimField">
									<input class="unSignalementField" id="placeId" name="placeIdS" type="hidden"></input>
								</td>
							</tr>
	      		</table>

						<label for="Geolocalisation"></label>
						<input type ="button" class="unSignalement" id="geocodeReverse"  onFocus="Geolocalisation()"></input>
					</fieldset>
					<fieldset id="descriptionSFied" name="decrire">
						<legend>Décrire</legend>
						<?php if($etat=="decrire"){
								echo '<div id="notif" class="warning"> <h2>Merci de décrire le problème</h2></div>';
						}?>
						<label for="typeS"></label>
						<input class="typeS" type = "hidden" name="typeS" id="selectType" required></input>
							<img class="imgType" alt="Place handicapée absente, occupée et/ou inadéquate." id="typeS1" src="img/typeS1.png "  onclick="change(1)" ></img>
							<img class="imgType" alt="Absence de signal sonore, tactile ou lumineux." id="typeS2" src="img/typeS2.png" onclick="change(2)"></img>
							<img class="imgType" alt="Passage inadapté et/ou encombré." id="typeS3" src="img/typeS3.png" onclick="change(3)"></img><br><br>
							<img type="image"class="imgType" alt="Problème d'accès en hauteur(rampe, ascenseur...)." id="typeS4" src="img/typeS4.png" onclick="change(4)"></img>
							<img type="image" class="imgType" alt="Sanitaires absents et/ou non adaptés." id="typeS5" src="img/typeS5.png" onclick="change(5)"></img>
							<img type="image"class="imgType" id="typeS6" src="img/typeS6.png" alt="Problème autre." onclick="change(6)"></img><br><br>
						<label for="descriptionS"></label>
							<textarea class="descriptionS" name="descriptionS" id="descriptionS" rows="3" cols="29"
							placeholder="Description du problème en 100 caractères maximum"></textarea>
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
						<button name="signaler" id="signaler" ><img id="doigt" src="img/doigt.svg"></img></button>
            </fieldset>
        </form>

		</div>
		<div id="mapcanvas"></div>
		<?php	include( 'autocomplete&geoloc.js');?>
		</div>
	</main>
	<?php include( 'footer.php');?>
	</body>
</html>
<?php
// ATTENTION FERMETURE DE LA SESSION SI ouverture
}else {

	header("location: index.php");

}

 ?>
