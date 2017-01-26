<?php
session_start();

/** Importation de l'autoloader **/

require 'Autoloader.php';
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
									echo  '<div class="msgsignal" id="'.$si->getIdS().'">
										<div class="gauchePost" id="infoS"  onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')" >
												<p>'.$si->getDescriptionS().'</p><p> '.$si->getVilleS().'</p>
												<p>Signalé le '.$si->getDateS().'</p>
											</div>
											<div class="droitePost" onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')" >
											<div ><img classe="latlng" src="img/'.$si->getTypeS().'.png" alt="Type du problème" height=60></div>
											<div ><button type="submit" name="signaler" class="soutiens1" id="doigtSoutien" onclick="idS='.$si->getIdS().'"><img src="img/doigt.svg" id="doigtSoutienImg" alt="Doigt"></button>
											<span class="nbsoutiens"> '.$si->getNSoutienS().'</span>
											</div>
											</div>
											<div class="crossPostit" id="crossPostit'.$si->getIdS().'" onclick="revenir()" style ="display:none">X</div>
										</div> <br>';

									$i++;
									$id++;
								}
							}
							$tabLatLng = $siMa->getTabLatLng();
							?>
							<script src="soutien.js"></script>
				</div>
				<div class= "mapcanvas"  id="mapcanvas">
				<?php include( 'userCarteZoom.js');?>
				</div>
      </div>
    </main>
    <?php include 'footer.php';?>
  </body>

</html>
