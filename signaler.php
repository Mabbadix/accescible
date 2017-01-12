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
		<div class = "navFix">
		<?php include 'headerNavSignaler.php'; ?>
	</div>
  </header>

  <main><!--CENTER-->
		<div class="mainUserCarte">
			<div class="mainLeft">
        <form class="unSignalementForm" name ="signalement" method = "post"
				 enctype="multipart/form-data"><center>
					<fieldset name="localiser" >
						<legend>Localiser</legend>
						</br>
						<table id="address1">
						<input class="unSignalementField" id="autocomplete" placeholder="Adresse complète, lieu, commerce etc." onFocus="initAutocomplete(), geolocate()" type="text"></input>
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
						OU </br></br>
						<label for="Geolocalisation"></label>
						<input class="unSignalement" id="geocodeReverse" type="button" value="Se géolocaliser" onFocus="Geolocalisation()"></input>
					</fieldset>
					<fieldset name="decrire">
						<legend>Décrire</legend>
							<label for="typeS"></label> <select
							class="typeS" name="typeS" id="typesS"required >
								<option name="typeS1" class="typeS" id="typesS">
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
						<label for="signaler"></label><br/><button  class="unSignalement"
						type="submit" name="signaler" value="signaler" id="signaler" formaction= "unSignalement.php">SIGNALER</button>
            </fieldset>
        </form>
		</div>
		<div id="mapcanvas"></div>

	<?php include( 'autocomplete&geoloc.js');?>

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
