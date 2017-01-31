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
    <?php $ut= $manageU->getUtilisateur($_SESSION['emailU'],$_SESSION['mdpU']);?>
    <!-- Partie centrale en dessous de navBar-->
    <div class="mainUserCarteCompte">
      <!-- Fin div mesinfos-->
      <div class="mainLeftCompte" id="listMonCompte">
        <div class="mesInfos">
          <h3 class="title-account2">Mes infos</h3>
          <p>
            <?php echo $_SESSION['emailU'] ?>
          </p>
          <div class="afficheInfos" id="afficheInfos" style ="display:""">
            <label for="nomU"><?php if (empty($ut->getNomU())) {echo 'Nom inconnu';}else{echo $ut->getNomU();}?></label>
            <br>
            <label for="prenomU"><?php if (empty ($ut->getPrenomU())) {echo 'Prénom inconnu';}else{echo $ut->getPrenomU();}?></label>
            <br>
            <label for="adresseU"><?php if (empty ($ut->getAdresseU())) {echo 'Adresse inconnue ';}else{echo $ut->getAdresseU();}?></label>
            <br>
            <label for="villeU"><?php if (empty($ut->getVilleU())) {echo 'Ville inconnue';}else{echo $ut->getVilleU();}?></label>
            <br>
            <label for="cpU"><?php if (empty($ut->getCpU())) {echo 'CP inconnu';}else{echo $ut->getCpU();}?></label>
            <br>
            <label for="telU"><?php if (empty($ut->getTelU())) {echo 'Tel  inconnu';}else{echo $ut->getTelU();}?></label>
            <br>
             <input class="BtnModifCompte" type="button" name="modifier" value="Modifier" onclick="modifierMonCompte()"/>
          </div>
          <div class="formModif" id="formModif" style="display:none">
            <form classe="formCompte" method="POST" action="compteTraitement.php">
            <label for="nomU">Nom:</label>
            </br><input class="champsCompte" type ="text" name="nomU" <?php if (empty($ut->getNomU())) {echo 'value=""';}else{echo 'value="'. $ut->getNomU().'"';}?>><br>
            <label for="prenomU">Prénom :</label>
            </br><input class="champsCompte" type ="text" name="prenomU" <?php if (empty($ut->getPrenomU())) {echo 'value=""';}else{echo 'value="'. $ut->getPrenomU().'"';}?>><br>
            <label for="adresseU">Adresse :</label>
            </br><input class="champsCompte" type ="text" name="adresseU" <?php if (empty($ut->getAdresseU())) {echo 'value=""';}else{echo 'value="'. $ut->getAdresseU().'"';}?>><br>
            <label for="villeU">Ville:</label>
            </br><input class="champsCompte" type ="text" name="villeU" <?php if (empty($ut->getVilleU())) {echo 'value=""';}else{echo 'value="'. $ut->getVilleU().'"';}?>><br>
            <label for="cpU">CP:</label>
            </br><input class="champsCompte" type ="text" name="cpU" <?php if (empty($ut->getCpU())) {echo 'value=""';}else{echo 'value="'. $ut->getCpU().'"';}?>><br>
            <label for="telU">Tel :</label>
            </br><input class="champsCompte" type ="text" name="telU" <?php if (empty($ut->getTelU())) {echo 'value=""';}else{echo 'value="'. $ut->getTelU().'"';}?>><br>
             <button class="ValideModifCompte" type="submit" name="valider">Valider</button>
             <input class="AnnulerModifCompte" type ="button" value="Annuler" onclick="annuler()"/>
            </form>
          </div>
        </div>
        <!-- Intégration des signalements à gauche de la carte + effet tournant -->
        <div class='mesSignalements'>
  				<?php
          $emailU=$_SESSION['emailU'];
  				$siMa = new SignalementManager($bdd);
          //on récupère le nbr de signal par l'utilisateur
  				$nSignal = $siMa->countSignalPar($emailU);
          echo"<h3 class='title-account2'>Mes signalements($nSignal)</h3>";
          //on récupère un tbl avec
          $tabSignalPar = $siMa->getTabSignalPar($emailU);
          foreach ($tabSignalPar as $signal) {
            $id= $signal['idS'];
            $si = $siMa->getSignal($id);
            echo  '<div class="msgsignal" id="'.$si->getIdS().'">
              <div class="gauchePost" id="infoS"  onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')" >
                  <p>'.$si->getDescriptionS().'</p><p> '.$si->getVilleS().'</p>
                  <p>Signalé le '.$si->getDateS().'</p>
                </div>
                <div class="droitePost" onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')" >
                <div ><img classe="latlng" src="img/'.$si->getTypeS().'.png" alt="Type du problème" height=60></div>
                <div><input class="button--circle" type="image" id="SoutienImg" src="img/fermer.png"  onclick="idS='.$si->getIdS().'"/>
                </div>
                <span class="nbsoutiens"> '.$si->getNSoutienS().'</span>
                </div>
                <div class="crossPostit" id="crossPostit'.$si->getIdS().'" onclick="revenir()" style ="display:none">X</div>
              </div> <br>';
          }
  				$tabLatLng = $siMa->getTabLatLng();?>
        </div>
        <div class="Désincription">
          <h3 class="title-account2">Se désincrire</h3>
          <button class="seDesinscrire" onclick="email='<?php echo $emailU ?>'" >Se désincrire</button>
        </div>
        <?php if($manageU->isConnected() === true && $_SESSION['confirme']==1){
        ?><script src="supprimerS.js"></script>
        <?php } ?>
      </div>
      <div class= "mapcanvas"  id="mapcanvas"></div>
			<?php include( 'userCarteZoom.php');?>
    </div>
  </main>
    <?php include 'footer.php';?>
  </body>
</html>
