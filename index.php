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

	//On récupère les infos saisies dans les imputs
	$Courriel = htmlspecialchars($_POST['Courriel']);
	$Mdp = sha1($_POST['Mot_de_passe']);

	// on créé une instance de UtilisateurManager
	$managerU = new UtilisateurManager ($bdd);

	//on verifie que le compte existe
	$exist = $managerU->exists($Courriel, $Mdp);

	/**********SI SE CONNECTER*************/

	if (isset($_POST['se_connecter']))
	{
		//si n'existe on informe;
		if (!$exist) {
				echo '<div id="notif" class="error"> <h2>Courriel ou mot de passe incorrect. Vérifiez votre saisie ou insrivez-vous. Merci.</h2></div><script type="text/javascript"> window.setTimeout("location=(\'index.php\');",1000) </script>';
		}
			//Si existe
		elseif ($exist) {
				//le manager instancie cet utilisateur via getUtilisateur qui renvoie un objet Utilisateur
				$ut = $managerU->getUtilisateur($Courriel, $Mdp);

				//On verfie que pas banni
			if ($ut->getValide() == 1) {
					//on verifie que compte n'est pas banni avec la donnée "valide" dela bd (1= bani, 0 = Ok);
					echo '<div id="notif" class="error"> <h2>Courriel non valide</h2></div><script type="text/javascript"> window.setTimeout("location=(\'index.php\');",1000) </script>';
			}
			// Si compte valide on accede au compte
			elseif ($ut->getValide() == 0) {
					//créé les parametres de session
				$_SESSION['emailU'] = $ut->getEmailU();
				$_SESSION['mdpU'] = $ut->getMdpU();
				$_SESSION['confirme'] = $ut->getConfirme();
				//on informe que logged est Ok pour redirection sur l'espace des gens inscrits
				$_SESSION['logged'] = true;
				//informe et on redirige
				echo '<div id="notif" class="success"> <h2>Bonjour, content de vous retrouver :)) </h2></div><script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",1000) </script>';
			}
		}
	}

	/**********SI CLIQUE S'INSCRIRE*************/
	elseif (isset($_POST['boutInscription']))
	{
		//On vérifie tout de même que si compte existe
		if ($exist)//si c'est le cas idem que btn "connexion"
		{
			//le manager instancie cet utilisateur
			$ut = $managerU->getUtilisateur($Courriel, $Mdp);
			//on verifie que compte n'est pas banni avec la donnée "valide" dela bd
			if ($ut->getValide() == 1) {
				echo '<div id="notif" class="error"> <h2>Courriel non valide</h2></div><script type="text/javascript"> window.setTimeout("location=(\'index.php\');",1000) </script>';
			}
			elseif ($ut->getValide() == 0)
			{
				//on créer la session
				$_SESSION['emailU'] = $ut->getEmailU();
				$_SESSION['mdpU'] = $ut->getMdpU();
				$_SESSION['confirme'] = $ut->getConfirme();
				//on informe que logged est Ok pour redirection sur l'espace des gens inscrits
				$_SESSION['logged'] = true;
			//on redirige
			echo '<div id="notif" class="warning"> <h2>Connexion réussie mais attention vous avez cliquez sur Inscription au lieu de Connexion</h2></div><script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",1100) </script>';
			}
		}
		elseif (!$exist)//Si aucun compte normalement
		{
			//on vérifie toutefois que l'email est pas pris avec verifEmailLibre()
			$emailPris = $managerU->verifEmailLibre($Courriel);
			if ($emailPris)
			{
				echo '<div id="notif" class="warning"> <h2>Ce courriel est déjà utilisé. Verifiez votre saisie. </h2></div><script type="text/javascript"> window.setTimeout("location=(\'index.php\');",1000) </script>';
			}
			elseif (!$emailPris)
			{
				// date du jour
				$date = date('Y-m-d');
				//création d'une Key pour envoie de mail
				$longueurKey = 16;
				$key = "";
				for($i=1;$i<$longueurKey;$i++)
				{
					$key .= mt_rand(0,9);
				}
				//on crée un Objet utilisateur, qu'on hydrate ac les données récupérées
				$utilisateur = new Utilisateur ([
					'emailU'=>$Courriel,
					'mdpU'=>$Mdp,
					'nomU'=>'Nom',
					'prenomU'=>'Prenom',
					'adresseU'=>'Adresse',
					'villeU'=>'Ville',
					'cpU'=>'00000',
					'telU'=>'0606060606',
					'dateU'=>$date,
					'signalU'=>'1',
					'valide'=>'0',
					'confirmKey'=>$key,
					'confirme'=> '0'
				]);

				//on appelle la fonction ajout avec en param l'objet utilisateur
				$managerU->add($utilisateur);
				//on envoie un mail de confirmation
				$managerU->envoieMail($Courriel, $key);
				echo '<div id="notif" class="Info"> <h2>Inscription réussie, bienvenue. Un email de confirmation vous a été envoyé.</h2></div><script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",1200) </script>';
			}
		}
	}
?>


<!DOCTYPE html>
<html lang="fr">
	<head>
		<!-- Integration de toutes les metas et autres link
				ATTENTION css propre à la page index = "style.css" -->
		<?php include 'head.php'; ?>
		<title>Acces'Cible-Accueil</title>
	</head>

	<body>
		<div class="video"><center>
			<video preload="auto" poster="img/logo73.svg" onclick="play()"  ondblclick="pause()">
			<source src="img/rendu_anim_handicap.mp4" type="video/mp4">
			Your browser does not support the video tag.
		</video ></center>
		</div>
		</br>

		<div>
			<!-- CONN ET INSCRIPTION !-->
			<form name ="formConn" method="post" id="button" style="text-align:center">
				<label for="Courriel"></label><input class="button connexion" id="Courriel" type="email"
					name="Courriel" placeholder="dupont@gmail.com"  required maxlength="100"><br/>
				<label for="Mot_de_passe"></label> <input class="button inscription" id="Mot_de_passe" type="password"
					name="Mot_de_passe" placeholder="Mot de passe" required maxlength="50"><br/>
					<label for="se_connecter"></label>
				<button class="button connexion" id="se_connecter" type="submit"
				name="se_connecter"value="se connecter" formaction = "index.php">Connexion</button>
				<button class="button inscription" type="submit" name="boutInscription" formaction="index.php">
					Inscription</button>
			</form>
		</div>
			</br>
		<script>
		/*******Notif qui apparait et disparaît*******/




		/*SLIDE SHOW INDEX*/
			var slideIndex = 0;
			showSlides();

			function showSlides() {
			    var i;
			    var slides = document.getElementsByClassName("mySlides");
			    var dots = document.getElementsByClassName("dot");
			    for (i = 0; i < slides.length; i++) {
			       slides[i].style.display = "none";
			    }
			    slideIndex++;
			    if (slideIndex> slides.length) {slideIndex = 1}
			    for (i = 0; i < dots.length; i++) {
			        dots[i].className = dots[i].className.replace(" active", "");
			    }
			    slides[slideIndex-1].style.display = "block";
			    dots[slideIndex-1].className += " active";
			    setTimeout(showSlides, 3000); // Change image every .... seconds
			}
		</script>
		<noscript>
			<div id="erreur"><b>Votre navigateur ne prend pas en charge JavaScript!</b> Veuillez activer JavaScript afin de profiter pleinement du site.</div>
		</noscript>
	</body>
</html>
