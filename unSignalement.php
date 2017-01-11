<?php
header( 'content-type: text/html; charset=utf-8' );
//******Connect BD********
//ouverture de session
session_start();
require("connData.php");
/***********pour faire un compteur VOIR LES VAR STATIC**********/
/********rendre les varaible global pour leur accessibilité******/


/*************Récupération des input dans des variable PHP****/
  /***Var de localisation du pb****/

$adresseS = htmlspecialchars($_POST["numero"].' '.$_POST["adresseS"]);
$cpS = htmlspecialchars($_POST["cpS"]);
$villeS = htmlspecialchars($_POST["villeS"]);
$regionS = htmlspecialchars($_POST["regionS"]);
$paysS = htmlspecialchars($_POST["paysS"]);
$latlng = htmlspecialchars($_POST["latlng"]);
$placeId = htmlspecialchars($_POST["placeId"]);



  /*****Var type de problème*****/
$typeS = htmlspecialchars($_POST["typeS"]);
$descriptionS = htmlspecialchars($_POST["descriptionS"]);

/****var date pb***/
$dateS = date("Y-m-d");

/*****var identifiant du signalant***/
$Courriel = htmlspecialchars($_POST["Courriel"]);
$Mdp = sha1($_POST["Mot_de_passe"]);

$idU = $_SESSION['emailU'];


/************* function enregistrement du S dans la BD***********/
$enregistrementS = $bdd->prepare("INSERT INTO signalements (signalPar, typeS, descriptionS, adresseS, villeS, cpS)
 VALUES ('$idU', '$typeS','$descriptionS','$adresseS','$villeS','$cpS','$dateS')");


function enregistrementSBd(){
  //*global $adresseS, $cpS, $villeS,$typeS,$descriptionS,$dateS,$Courriel,$Mdp,$idU, $enregistrementS;*/
  $enregistrementS->execute();
    //oN VÉRIFIE QU'IL N'Y PAS DE PROBLÈME AVEC L'ENRISTREMENT DEs LA BD
   if (!$enregistrementS) {
         die('Requête invalide : ' . mysql_error());
       }
   else {
     echo '<div id="ok">Signalement enregistré. Redirection en cours...</div>
     <script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",500) </script>';
   }
}

/****fonction controle et enregistrement photo dan un dossier ****/
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

                   }
         else {
          echo"Le format du fichier n'est pas accepté.Seuls sont acceptés,les fichiers en .jpg, .jpeg, .gif, .png";
        }
       }
      elseif ($_FILES["photoS"]["size"] > $maxsize){
        $erreur = "Le fichier est trop gros";
        echo $erreur;
      }
    }
    elseif($_FILES ["photoS"]["error"]>0){
      echo "Erreur lors du transfert";
    }
  }

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
    if (empty($typeS) OR $typeS=0){
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
    else {
      if($_FILES["photoS"][size] > 0){
        enregistrentPhotoS();
        enregistrementSBd();
      }
      else {
        enregistrementSBd();
      }
     }
   }

?>
