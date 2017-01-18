<!DOCTYPE html>
<html>
  <head>
  <title>Retrieving Autocomplete Predictions</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #right-panel {
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }

      #right-panel select, #right-panel input {
        font-size: 15px;
      }

      #right-panel select {
        width: 100%;
      }

      #right-panel i {
        font-size: 12px;
      }
    </style>
  </head>
  <body>
    <div id="right-panel">
      <p>Query suggestions for 'pizza near Syd':</p>
      <ul id="results"></ul>
    </div>
    <script>
      // This example retrieves autocomplete predictions programmatically from the
      // autocomplete service, and displays them as an HTML list.

      // This example requires the Places library. Include the libraries=places
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=places">

      function initService() {
        var displaySuggestions = function(predictions, status) {
          if (status != google.maps.places.PlacesServiceStatus.OK) {
            alert(status);
            return;
          }

          predictions.forEach(function(prediction) {
            var li = document.createElement('li');
            li.appendChild(document.createTextNode(prediction.description));
            document.getElementById('results').appendChild(li);
          });
        };

        var service = new google.maps.places.AutocompleteService();
        service.getQueryPredictions({ input: 'pizza near Syd' }, displaySuggestions);
      }
    </script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDTFqUmefn5-fJ2E20dOfyH-0-jVbZx5Lc&libraries=places&callback=initService"
        async defer></script>
  </body>
</html>
<?php
/***********traitement d'un Signalement en POO*/

//On récupère les imputs ou créé des infos
$signalPar = $_SESSION['emailU'];
/*****Var type de problème*****/
$typeS = htmlspecialchars($_POST["typeS"]);
$descriptionS = htmlspecialchars($_POST["descriptionS"]);
/***Var identification S*///
$adresseS = htmlspecialchars($_POST["numero"].' '.$_POST["adresseS"]);
$villeS = htmlspecialchars($_POST["villeS"]);
$cpS = htmlspecialchars($_POST["cpS"]);
$regionS = htmlspecialchars($_POST["regionS"]);
$paysS = htmlspecialchars($_POST["paysS"]);
$latlng = htmlspecialchars($_POST["latlng"]);
$placeId = htmlspecialchars($_POST["placeId"]);
$photoS='0';
$dateS = date("Y-m-d");
/****var autre de la bd***/
$resoluS='0';
$interventionS='0';
$nSoutienS='0';

	// on créé une instance de SignalementManager
	$managerS = new SignalementManager($bdd);

	/**********SI CLIQUE SIGNALER*************/
if (isset($_POST['signaler'])){
	//on enregistre en bdd
	$si= new Signalement([
		'signalPar'=> $signalPar,
		'typeS'=>	$typeS,
		'descriptionS'=> $descriptionS,
		'adresseS'=> $adresseS,
		'villeS'=> $villeS,
		'cpS'=> $cpS,
		'regionS'=>	$regionS,
		'paysS'=> $paysS,
		'latlng'=> $latlng,
		'placeId'=> $placeId,
		'photoS'=> 	$photoS,
		'dateS'=> $dateS,
		'resoluS'=> 	$resoluS,
		'interventionS'=> $interventionS,
		'nSoutienS'=>	$nSoutienS
	]);
	//on appelle la fonction ajout avec en param l'objet un Signalement
	$managerS->add($si);
}
?>
