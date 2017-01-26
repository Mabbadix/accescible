<?php
session_start();

/** Importation de l'autoloader **/

require '../Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

//******Connect BD********

require '../connData.php';

/**********SI SE CONNECTER*************/

if (isset($_POST['se_connecter']))
{
    //On récupère les infos saisies dans les imputs

	$Courriel = htmlspecialchars($_POST['Courriel']);
	$Mdp = sha1($_POST['Mot_de_passe']);

    // on créé une instance de UtilisateurManager

	$managerU = new UtilisateurManager ($bdd);


	//on verifie que le compte existe

	$exist = $managerU->exists($Courriel, $Mdp);

    //si n'existe on informe;
    if (!$exist)
    {
        echo '<div id="notif" class="error"> <h2>Courriel ou mot de passe incorrect. Vérifiez votre saisie ou insrivez-vous. Merci.</h2></div><script type="text/javascript"> window.setTimeout("location=(\'index.php\');",1000) </script>';
    }
    //Si existe
    elseif ($exist)
    {
        //le manager instancie cet utilisateur via getUtilisateur qui renvoie un objet Utilisateur

        $isAdmin = $managerU->isAdmin($Courriel);
        if ($isAdmin['admin'] == 1) {

            $ut = $managerU->getUtilisateur($Courriel, $Mdp);
            //créé les parametres de session

            $_SESSION['emailU'] = $ut->getEmailU();
            $_SESSION['mdpU'] = $ut->getMdpU();
            $_SESSION['admin'] = $ut->getAdmin();

            //on informe que logged est Ok pour redirection sur l'espace des gens inscrits

            $_SESSION['logged'] = true;
            //informe et on redirige
            echo '<div id="notif" class="success"> <h2>Bonjour, content de vous retrouver :)) </h2></div><script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",1000) </script>';
	    }else{
            echo '<div id="notif" class="error"> <h2>Vous n\'etes pas administrateur</h2></div><script type="text/javascript"> window.setTimeout("location=(\'../index.php\');",1000) </script>';
        }  
    }   
}
?>


<!DOCTYPE html>
<html lang="fr">
	<head>
		<?php 
        $type = 'admin';
        include '../head.php';
        ?>
		<title>Acces'Cible-Admin</title>
	</head>

	<body>
		<div class="indexMain">

		<div class="video">
			<video preload="auto" poster="../img/logo73.svg" onclick="play()"  ondblclick="pause()">
			<source src="../img/rendu_anim_handicap.mp4" type="video/mp4">
			Your browser does not support the video tag.
		</video >
		</div>
		<br>
        <h2 class="centeradmin">Administation</h2>
		<div>
			<!-- CONN ET INSCRIPTION !-->
			<form name ="formConn" method="post" id="button" style="text-align:center">
				<label for="Courriel"></label><input class="button connexion" id="Courriel" type="email" name="Courriel" placeholder="dupont@gmail.com" value="<?php if (!empty($_POST['Courriel'])) {echo stripcslashes(htmlspecialchars($_POST['Courriel'], ENT_QUOTES));} ?>"  required maxlength="100"><br>
				<label for="Mot_de_passe"></label> <input class="button inscription" id="Mot_de_passe" type="password"
					name="Mot_de_passe" placeholder="Mot de passe" required maxlength="50"><br>
					<label for="se_connecter"></label>
				<button class="button connexion" id="se_connecter" type="submit"
				name="se_connecter" value="se connecter" formaction = "index.php">Connexion</button>
			</form>
		</div>
		</div>
			<br>
		
		<noscript>
			<div id="erreur"><b>Votre navigateur ne prend pas en charge JavaScript!</b> Veuillez activer JavaScript afin de profiter pleinement du site.</div>
		</noscript>
	</body>
</html>
