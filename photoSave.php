<?php
  	//Test que fichier bien envoyé
	if(isset($_FILES["photoS"]) AND $_FILES["photoS"]["error"] == 0){
     // Testons si le fichier n"est pas trop gros
     $maxsize = 100;
     if ($_FILES["photoS"]["size"] <= $maxsize){
        // Testons si l'extension est autorisée
        $infosfichier = pathinfo($_FILES["photoS"]["name"]);
        $nomPhotoS = $_FILES["photoS"]["name"];
        $extension_upload =  $infosfichier["extension"]; //OU $extension_upload = strtolower(substr(strrchr($_FILES ["photoS"] ["name"], "."), 1));
        $extension_autorisees = array("jpg", "jpeg", "gif", "png");
        if (in_array($extension_upload, $extension_autorisees)){
         //Si tout est bon, on accepte le fichier ac 2 parametres (1=destination temp du fichier, 2= destiantion finale du fichier )
         move_uploaded_file($_FILES["photoS"]["tmps_name"], //=1
          "uploadsPhotoS/".basename($_FILES["photoS"]["name"]));//=2 en amélioré car on garde le nom du fichier en le telechargement et on le mets dans un dossier /upload
					echo ("<script language='JavaScript' type='text/javascript'>");
				 	echo ('alert("le fichier a bien été téléchargé");');
        }else {
					echo ("<script language='JavaScript' type='text/javascript'>");
					echo ('alert("Le format du fichier n\'est pas accepté.Seuls sont acceptés,les fichiers en .jpg, .jpeg, .gif, .png");');
					echo ("</script>");

        }
     	}
	     elseif ($_FILES["photoS"]["size"] > $maxsize){
				 echo ("<script language='JavaScript' type='text/javascript'>");
				 echo ('alert("Le fichier est trop gros");');
				 echo ('history.back(-1)');
				 echo ("</script>");
	     }
		}
		 elseif($_FILES ["photoS"]["error"]>0){
			 echo ("<script language='JavaScript' type='text/javascript'>");
			 echo ('alert("Erreur lors du transfert");');
			 echo ('history.back(-1)');
			 echo ("</script>");
	 }
 ?>
