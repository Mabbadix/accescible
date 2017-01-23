<!--Petit slide show pour la transition + info  -->
<!DOCTYPE html>
<html lang="fr">
<head>
	<!-- Integration de toutes les metas et autres link
			ATTENTION css propre à la page index = "style.css" -->
	  <?php include 'headUtilisateur.php'; ?>
	<title>Acces'Cible-Accueil</title>
</head>
<body>
		<!-- SLIDE SHOW INDEX!-->
		<div class="slideshow-container">
			<div class="mySlides fade">
			  <div class="numbertext">1 / 3</div>
			  <img src="img/logo71.svg" style="width:100%">
			  <div class="text">SIGNALEMENT</div>
			</div>
			<div class="mySlides fade">
			  <div class="numbertext">2 / 3</div>
			  <img src="img/logo72.svg" style="width:100%">
			  <div class="text">EN COURS D'ENREGISTREMENT.</div>
			</div>
			<div class="mySlides fade">
			  <div class="numbertext">3 / 3</div>
			  <img src="img/logo73.svg" style="width:100%">
			  <div class="text">MERCI</div>
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
		<script>
		/*SLIDE SHOW INDEX*/
      window.setTimeout("location=(\'userCarte.php\');",2900)
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
					setTimeout(showSlides,1000); // Change image every 2 seconds
			}
		</script>
		<noscript><div id="erreur"><b>Votre navigateur ne prend pas en charge JavaScript!</b> Veuillez activer JavaScript afin de profiter pleinement du site.</div></noscript>
		</body>
</html>
