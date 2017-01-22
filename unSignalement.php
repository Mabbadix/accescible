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
/***********traitement d'un Signalement en POO*/
include ("headUtilisateur.php");
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
$latlng = htmlspecialchars($_POST["latlngS"]);
$placeId = htmlspecialchars($_POST["placeIdS"]);
$dateS = date("Y-m-d");

/******Gestion enregistrement photo******/
global $photoControl;

if($_FILES["photoS"]["size"] > 0){
	//Test que fichier bien envoyé
if(isset($_FILES["photoS"]) AND $_FILES["photoS"]["error"] == 0){
	 // Testons si le fichier n"est pas trop gros
	 $maxsize = 10000000;
	 if ($_FILES["photoS"]["size"] <= $maxsize){
			// Testons si l'extension est autorisée
			$infosfichier = pathinfo($_FILES["photoS"]["name"]);
			$nomPhotoS = $_FILES["photoS"]["name"];
			$extension_upload =  strtolower(substr(strrchr($_FILES ["photoS"] ["name"], "."), 1));//ou $infosfichier["extension"]
			$extension_autorisees = array("jpg", "jpeg", "gif", "png", "svg");

			if (in_array($extension_upload, $extension_autorisees)){

			 //on créé un nom aléatoire a ajouté
			 $nom = md5(uniqid(rand(), true));

			 //Si tout est bon, on accepte le fichier ac 2 parametres (1=destination temp du fichier, 2= destiantion finale du fichier )
			 move_uploaded_file($_FILES["photoS"]["tmps_name"], //=1
				"uploadsPhotoS/".$nom.basename($_FILES["photoS"]["name"]));//=2 en amélioré car on garde le nom du fichier en le telechargement et on le mets dans un dossier /upload

				$photoControl= "uploadsPhotoS/".$nom.basename($_FILES["photoS"]["name"]);
			}else{
				$photoControl= "format";
			}
		}
		 elseif ($_FILES["photoS"]["size"] > $maxsize){
			 $photoControl = "taille";
		 }
	}
	 elseif($_FILES ["photoS"]["error"]>0){
		 $photoControl = "erreurChargement";
 }
}else {
	$photoControl ="pasDePhoto";
}

$photoS = $photoControl;
/****var autre de la bd***/
$resoluS='0';
$interventionS='0';
$nSoutienS='0';

// on créé une instance de SignalementManager
$managerS = new SignalementManager($bdd);

/**********SI CLIQUE SIGNALER*************/
/**** vérification des données saisies et enregistrement BD**/
if(isset($_POST['signaler'])){
	//si localiser est vide (soit adresse, soit géoloc)
	if(empty($adresseS) AND empty($cpS) OR empty($villeS) ){
		echo '<div id="notif" class="warning"> <h2>Merci de localiser le problème</h2></div><script type="text/javascript">
		$(document).ready(function(){
		$("#notif").fadeOut(5000);
		});
		window.setTimeout("location=(\'signaler.php\');",1500)</script>';
	}//Si choix types EST vide
	elseif (empty($typeS)){
		echo '<div id="notif" class="warning"> <h2>Merci de décrire le problème</h2></div><script type="text/javascript">
		$(document).ready(function(){
		$("#notif").fadeOut(5000);
		});
		window.setTimeout("location=(\'signaler.php\');",1500)</script>';
	}elseif($photoS == "format"){
		echo '<div id="notif" class="error"> <h2>Le format du fichier n\'est pas accepté. Seuls sont acceptés,les fichiers en .jpg, .jpeg, .gif, .png, .svg. Merci de recommencer.</h2></div><script type="text/javascript">
		$(document).ready(function(){
		$("#notif").fadeOut(5000);
		});
		window.setTimeout("location=(\'signaler.php\');",1500)</script>';
			}elseif($photoS == "taille"){
				echo '<div id="notif" class="error"> <h2>La photo est trop volumineuse. Merci de recommencer.</h2></div><script type="text/javascript">
				$(document).ready(function(){
				$("#notif").fadeOut(5000);
				});
				window.setTimeout("location=(\'signaler.php\');",1500)</script>';
			}elseif($photoS == "erreurChargement"){
				echo '<div id="notif" class="error"> <h2>Erreur dinconnue lors du chargement de la photo. Merci de recommencer.</h2></div><script type="text/javascript">
				$(document).ready(function(){
				$("#notif").fadeOut(5000);
				});
				window.setTimeout("location=(\'signaler.php\');",1500)</script>';
	}	else {//sinon lancement des functions idoines
			/****création d'un obj signalement + enregistrement ****/
			// on créé une instance de SignalementManager
		 $managerS = new SignalementManager($bdd);
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
		 echo '<div id="notif" class="success"> <h2>Votre signalement a bien été enregistré. Merci à vous.</h2></div><script type="text/javascript">
 		$(document).ready(function(){
 		$("#notif").fadeOut(5000);
 		});
 		window.setTimeout("location=(\'userCarte.php\');",1500)</script>';
	}
}
?>
