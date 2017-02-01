<?php
session_start();

/** Importation de l'autoloader **/

require 'class/Autoloader.php';
$autoload = new Autoloader;
$autoload->register();

if (isset($_GET['deconnexion']))
{
  require 'deconn.php';
}

//******Connect BD********

require 'connData.php';

/***********traitement sur la page index*/

  $manageU = new UtilisateurManager($bdd);
?>
  <!DOCTYPE html>
  <html lang="fr">

  <head>
    <!-- integration de toutes les metas et autres link
				ATTENTION link styleUser.css different du "style.css" -->
    <?php
		$type = 'utilisateur';
		include 'head.php';
		?>
      <title>Acces'Cible-Carte_Utilisateur</title>

  </head>

  <body>
		<div class="site-container">
      <?php include'header.php'; ?>
 		<div class="site-pusher">
		<div class="site-content">
    <div class="container">
    <main>
      <!-- Partie centrale en dessous de navBar-->
      <div class="mainUserCarte">
        <div class="mainLeft" id="listSignal">
          <!-- Intégration des signalements à gauche de la carte + effet tournant -->
          <?php
							$siMa = new SignalementManager($bdd);
							$nSignal = $siMa->count();
							$i=0;//compteur du nombre de signalements
							$id=0;// compteur des id à augmenter de temps en temps :))

							while ($i<$nSignal){
								$siExist = $siMa->exists($id);
								if(!$siExist){
									//	ici on pourrait regarder de temps en temps pour faire partir le compteur
									$id++;
								}else{
									$si = $siMa->getSignal($id);
									echo  '<div class="postit" id="'.$si->getIdS().'">
										<div class="postit--left" id="infoS"  onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')" >
												<p>'.$si->getDescriptionS().'</p><p> '.$si->getVilleS().'</p>
												<p>Signalé le '.$si->getDateS().'</p>
											</div>
											<div class="postit--right">
											<div class="postit--type" onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')">
                      <img classe="latlng" src="img/'.$si->getTypeS().'.png" alt="Type du problème" height=60>
                      <div class="crossPostit" id="crossPostit'.$si->getIdS().'" onclick="revenir()" style ="display:none">X</div>
                      </div>
                      <div class="postit--signal"><input class="button--circle" type="image" name="signaler" id="SoutienImg" src="img/jaime_orange.svg"  onclick="idS='.$si->getIdS().'"/>
											<span class="nbsoutiens"> '.$si->getNSoutienS().'</span>
											</div>
            				</div> </div>';
									$i++;
									$id++;
								}
							}
							$tabLatLng = $siMa->getTabLatLng();
							if($manageU->isConnected() === true && $_SESSION['confirme']==1){
								?>
              <script src="userCarteSoutien.js"></script>
              <?php } ?>
        </div>
        <div class="mapcanvas" id="mapcanvas">
          <?php include 'userCarteZoom.php';?>
        </div>
      </div>
    </main>
    <?php include 'footer.php';?>
	</div>
  </div>
  <div class="site-cache" id="site-cache"></div>
  </div>
  </div>
  </body>
  <script src="js/app.js"></script>
   <script>
    var forEach=function(t,o,r){if("[object Object]"===Object.prototype.toString.call(t))for(var c in t)Object.prototype.hasOwnProperty.call(t,c)&&o.call(r,t[c],c,t);else for(var e=0,l=t.length;l>e;e++)o.call(r,t[e],e,t)};

    var hamburgers = document.querySelectorAll(".hamburger");
    if (hamburgers.length > 0) {
      forEach(hamburgers, function(hamburger) {
        hamburger.addEventListener("click", function() {
          this.classList.toggle("is-active");
        }, false);
      });
    }
  </script>
  </html>
