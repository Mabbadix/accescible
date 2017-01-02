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
				echo "<script language='JavaScript' type='text/javascript'>";
				echo 'alert("Aucun compte ne correspond à ces données ! Inscrivez-vous ou verifiez votre saise. Merci");';
				echo 'history.back(-1)';
				echo '</script>';
		}
			//Si existe
		elseif ($exist) {
				//le manager instancie cet utilisateur via getUtilisateur qui renvoie un objet Utilisateur
				$ut = $managerU->getUtilisateur($Courriel, $Mdp);
				//On verfie que pas banni
			if ($ut->getvalide() == 1) {
					//on verifie que compte n'est pas banni avec la donnée "valide" dela bd (1= bani, 0 = Ok);
				echo "<script language='JavaScript' type='text/javascript'>";
					echo 'alert("Votre compte a été bloqué");';
					echo 'history.back(-1)';
					echo '</script>';
			}
			// Si compte valide on accede au compte
			elseif ($ut->getvalide() == 0) {
					//créé les parametre de session
				$_SESSION['emailU'] = $ut->getEmailU();
				$_SESSION['mdpU'] = $ut->getMdpU();
				$_SESSION['logged'] = true;
				//informe et on redirige
				echo '<div id="ok">Connexion réussie. Redirection en cours...</div>
				<script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",500) </script>';
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
			if ($ut->getvalide() == 1) {
					echo "<script language='JavaScript' type='text/javascript'>";
					echo 'alert("Votre compte a été bloqué, vous ne pouvez vous réinscrire!");';
					echo 'history.back(-1)';
					echo '</script>';
			}
			elseif ($ut->getvalide() == 0)
			{
				//on créer la session
				$_SESSION['emailU'] = $ut->getEmailU();
				$_SESSION['mdpU'] = $ut->getMdpU();
			//on redirige
				echo '<div id="ok">Connexion réussie mais attention vous avez cliquez sur Inscription au lieu de Connexion</div>
				<script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",1000) </script>';
			}
		}
		elseif (!$exist)//Si aucun compte normalement
		{
			//on vérifie toutefois que l'email est pas pris avec verifEmailLibre()
			$emailPris = $managerU->verifEmailLibre($Courriel);
			if ($emailPris)
			{
				echo "<script language='JavaScript' type='text/javascript'>";
				echo 'alert("Ce courriel est déjà utilisé! Connectez-vous ou verifiez votre saise. Merci");';
				echo 'history.back(-1)';
				echo '</script>';
			}
			elseif (!$emailPris)
			{
				// date du jour
				$date = date('Y-m-d');
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
					'confirmKey'=>'ConfirmKey',
					'confirme'=> '1'
				]);
				//on appelle la fonction ajout avec en param l'objet utilisateur
				$managerU->add($utilisateur);
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
		<!-- SLIDE SHOW INDEX!-->
		<div class="slideshow-container">
			<div class="mySlides fade">
			  <div class="numbertext">1 / 3</div>
			  <img src="img/logo71.svg" style="width:100%">
			  <div class="text">signaler</div>
			</div>
			<div class="mySlides fade">
			  <div class="numbertext">2 / 3</div>
			  <img src="img/logo72.svg" style="width:100%">
			  <div class="text">signaler - décider</div>
			</div>
			<div class="mySlides fade">
			  <div class="numbertext">3 / 3</div>
			  <img src="img/logo73.svg" style="width:100%">
			  <div class="text">signaler - décider - adapter</div>
			</div>
		</div>
		</br>

		<!-- BOUTON ROND !-->
		<div id="dot" style="text-align:center">
		  <span class="dot"></span>
		  <span class="dot"></span>
		  <span class="dot"></span>
		</div>
		</br>
    <div>
			<!-- CONN ET INSCRIPTION !-->
			<form name ="formConn" method="post" id="button" style="text-align:center">
				<label for="Courriel"></label><input class="button connexion" id="Courriel" type="email"
					name="Courriel" placeholder="dupont@gmail.com<?php if (!empty($_POST['Courriel'])) {echo stripcslashes(htmlspecialchars($_POST['Courriel'], ENT_QUOTES));} ?>"  required maxlength="100"><br/>
	      <label for="Mot_de_passe"></label> <input class="button inscription" id="Mot_de_passe" type="password"
					name="Mot_de_passe" placeholder="Mot de passe<?php if (!empty($_POST['Mot_de_passe'])) {echo stripcslashes(htmlspecialchars($_POST['Mot_de_passe'], ENT_QUOTES));} ?>" required maxlength="50"><br/>
					<label for="se_connecter"></label>
				<button class="button connexion" id="se_connecter" type="submit"
				name="se_connecter"value="se connecter" formaction = "index.php">Connexion</button>
				<button class="button inscription" type="submit" name="boutInscription" formaction="index.php">
					Inscription</button>
			</form>
		</div>

		<script>
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
			    setTimeout(showSlides, 3500); // Change image every .... seconds
			}
		</script>
		<noscript>
			<div id="erreur"><b>Votre navigateur ne prend pas en charge JavaScript!</b> Veuillez activer JavaScript afin de profiter pleinement du site.</div>
		</noscript>
	</body>
</html>

<!--div id="conteneur">
	<button class="button connexion" >Connexion</button>
	<button class="button inscription">Inscription</button>
</div>
<header>

	header
</header>

<nav>
	nav
</nav>
<main>
	main
	<section>
		section
	</section>
	<article>
		article
	</article>
	<aside>
			side
	</aside>
</main>
<footer>
	footer
</footer!-->
