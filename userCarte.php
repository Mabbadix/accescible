<?php
session_start();
header('content-type: text/html; charset=utf-8');

//fonction qui recherche toute seule la classe à requerir
function chargerClass($classe)
{
	require $classe.'.php';
}
spl_autoload_register('chargerClass');

if (isset($_GET['deconnexion']))
{
  require 'deconn.php';
}

//******Connect BD********
require 'connData.php';
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.

/***********traitement sur la page index*/

  $manageU = new UtilisateurManager($bdd);
?>
  <!DOCTYPE html>
  <html lang="fr">

  <head>
    <!-- integration de toutes les metas et autres link
				ATTENTION link styleUser.css different du "style.css" -->
    <?php	include 'headUtilisateur.php'; ?>
    <title>Acces'Cible-Carte_Utilisateur</title>

  </head>

  <body>
    <header>
			<div class="navFix">
				<!-- Nav Bar + Side -->
	      <!-- ATTENTION headerNav different pour chaque page pour selection du bon onglet" -->
	      <?php
				$nav_en_cours = 'usercarte';
				include 'headerNavUserCarte.php'; ?>
			</div>
    </header>
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
									echo  '<div class="msgsignal" onclick="zoomPost('.$si->getLat().', '.$si->getLng().')"  >
											<div class="gauchePost" id="infoS">
												<p>'.$si->getDescriptionS().'</p><p> '.$si->getVilleS().'</p>
												<p>Signalé le '.$si->getDateS().'</p>
											</div>
											<div class="droitePost">
											<div ><img classe="latlng" src="img/'.$si->getTypeS().'.png" alt="Type du problème" height=60></div>
											<div ><button type="submit" name="signaler" class="soutiens1" id="doigtSoutien" onclick="idS='.$si->getIdS().'"><img src="img/doigt.svg" id="doigtSoutienImg" alt="Doigt"></button>
											<span class="nbsoutiens">'.$si->getNSoutienS().'</span></div>
											<input  id="lat" class="lat"  type="hidden" value="'.$si->getLat().'"></input>
									    <input  id="lng" class="lng" type="hidden" value="'.$si->getLng().'"></input>
											</div>
										</div> <br>';

									$i++;
									$id++;
								}
							}
							$tabLatLng = $siMa->getTabLatLng();
							?>
				</div>
				<div class= "mapcanvas"  id="mapcanvas">
					<?php	include( 'userCarteZoom.js');?>
					<!-- Intégration de la carte + Geolocation + placement maker -->
					<!-- Laisser ce script à l'exterieur du script de recupération MAP-->

				</div>
      </div>
    </main>
    <?php include( 'footer.php');?>
  </body>

</html>
