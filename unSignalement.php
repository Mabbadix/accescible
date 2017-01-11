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
$photoS='0';
$dateS = date("Y-m-d");
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
				echo ("<script language='JavaScript' type='text/javascript'>");
				echo ('alert("Merci de localiser le problème ");');
				echo ('history.back(-1)');
				echo ("</script>");
			}
			//Si DECRIRE EST vide
			if (empty($typeS)){
				echo ("<script language='JavaScript' type='text/javascript'>");
				echo ('alert("Merci de choisir dans la liste un type de problème");');
				echo ('history.back(-1)');
				echo ("</script>");
			}
			//Si pas de description ou pas de photo
			/*if (empty($descriptionS) AND $_FILES["photoS"][size] == 0){
					echo ("<script language='JavaScript' type='text/javascript'>");
					echo ('alert("Merci de faire une petite description OU/ET de joindre une photo");');
					echo ('history.back()');
					echo ("</script>");
				}*/
			else {//sinon lancement des functions idoines
				if($_FILES["photoS"][size] > 0){
					enregistrentPhotoS();
				}
				/****fonction création d'un obj signalement + enregistrement ****/
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
					echo '<div id="ok">Signalement enregistré. Redirection en cours...</div>
					<script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",500) </script>';
			 }
		 }
		 function enregistrentPhotoS(){
			   /*$_FILES["photoS"]["name"]//Le nom original du fichier,
		     //comme sur le disque du visiteur (exemple : mon_icone.png).
		     $_FILES["photoS"]["type"] //Le type du fichier.
		     //Par exemple, cela peut être « image/png ».
		     $_FILES ["photoS"]["size"]//taille en octets
		     $_FILES ["photoS"]["tmps_name"]// adresse du fichier uploadé dans temp
		     $_FILES["photoS"]["error"]//code erreur pour savoir si fichier est upload*/
		         //Test que fichier bien envoyé
		     if(isset($_FILES["photoS"])AND $_FILES["photoS"]["error"] == 0){
		       // Testons si le fichier n"est pas trop gros
	         $maxsize = 1000000;
	         if ($_FILES["photoS"]["size"] <= $maxsize){
	            // Testons si l'extension est autorisée
	            $infosfichier = pathinfo($_FILES["photoS"]["name"]);
	            $nomPhotoS = $_FILES["photoS"]["name"];
	            $extension_upload =  $infosfichier["extension"]; //OU $extension_upload = strtolower(substr(strrchr($_FILES ["photoS"] ["name"], "."), 1));
	            $extension_autorisees = array("jpg", "jpeg", "gif", "png");
	            if (in_array($extension_upload, $extension_autorisees)){
	             //Si tout est bon, on accepte le fichier ac 2 parametres (1=destination temp du fichier, 2= destiantion finale du fichier )
	             move_uploaded_file($_FILES["photoS"]["tmps_name"], //=1
	              "uploadsPhotoS/".basename($_FILES["photoS"]["name"]));//=2 en amélioré car ongarde le nom du fichier en le telechargement et on le mets dans un dossier /upload
	                 echo "L'envoi ok";
	                 echo "Retrouvez la à";
	              }else {
	             echo"Le format du fichier n'est pas accepté.Seuls sont acceptés,les fichiers en .jpg, .jpeg, .gif, .png";}
	         }
	         elseif ($_FILES["photoS"]["size"] > $maxsize){
	           $erreur = "Le fichier est trop gros";
	           echo $erreur;
	         }
	       }
	       elseif($_FILES ["photoS"]["error"]>0){
	         echo "Erreur lors du transfert";
	       }
		 };
?>
