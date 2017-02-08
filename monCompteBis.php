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
    <title>Acces'Cible-Mon_Compte</title>
  </head>
  <body>
    <div class="site-container">
      <?php include'header.php'; ?>
 		<div class="site-pusher">
		<div class="site-content">
    <div class="container">
    <main>
    <?php $ut= $manageU->getUtilisateur($_SESSION['emailU'],$_SESSION['mdpU']);?>
    <!-- Partie centrale en dessous de navBar-->
    <div class="mainUserCarte">
      <!-- Fin div mesinfos-->
      <div class="mainLeftCompte">
        <div class="mesInfos">
          <h3 class="title-account2">Mes infos</h3>
          <p>
            <?php echo $_SESSION['emailU'] ?>
          </p>
          <div class="afficheInfos" id="afficheInfos" style ="display:""">
            <label for="nomU">Nom:</label>
          </br><input class="champsCompte" disabled="true" type ="text" name="nomU" <?php if (empty($ut->getNomU())) {echo 'value="inconnu"';}else{echo 'value="'. $ut->getNomU().'"';}?>><br>
            <label for="prenomU">Prénom :</label>
          </br><input class="champsCompte" disabled="true" type ="text" name="prenomU" <?php if (empty($ut->getPrenomU())) {echo 'value="inconnu"';}else{echo 'value="'. $ut->getPrenomU().'"';}?>><br>
            <label for="adresseU">Adresse :</label>
          </br><input class="champsCompte" disabled="true" type ="text" name="adresseU" <?php if (empty($ut->getAdresseU())) {echo 'value="inconnue"';}else{echo 'value="'. $ut->getAdresseU().'"';}?>><br>
            <label for="villeU">Ville:</label>
          </br><input class="champsCompte" disabled="true" type ="text" name="villeU" <?php if (empty($ut->getVilleU())) {echo 'value="inconnue"';}else{echo 'value="'. $ut->getVilleU().'"';}?>><br>
            <label for="cpU">CP:</label>
          </br><input class="champsCompte" disabled="true" type ="text" name="cpU" <?php if (empty($ut->getCpU())) {echo 'value="inconnu"';}else{echo 'value="'. $ut->getCpU().'"';}?>><br>
            <label for="telU">Tel :</label>
          </br><input class="champsCompte" disabled="true" type ="text" name="telU" <?php if (empty($ut->getTelU())) {echo 'value="inconnu"';}else{echo 'value="'. $ut->getTelU().'"';}?>><br>
             <input class="BtnModifCompte" type="button" name="modifier" value="Modifier" onclick="modifierMonCompte()"/>
          </div>
          <div class="formModif" id="formModif" style="display:none">
            <form classe="formCompte" method="POST" action="monCompteTraitement.php">
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
            echo  '<div class="postit" id="'.$si->getIdS().'">
              <div class="postit--left" id="infoS"  onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')" >
                  <p>'.$si->getDescriptionS().'</p><p> '.$si->getVilleS().'</p>
                  <p>Signalé le '.$si->getDateS().'</p>
                </div>
                <div class="postit--right" onclick="zoomPost('.$si->getLat().', '.$si->getLng().', '.$si->getIdS().')" >
                <div class="postit--type">
                <img classe="latlng" src="img/'.$si->getTypeS().'.png" alt="Type du problème" height=60>
                <div class="crossPostit" id="crossPostit'.$si->getIdS().'" onclick="revenir()" style ="display:none">X</div>
                </div>
                <div class="postit--signal"><input class="button--circle supprimer" type="image" id="supprimerS" src="img/fermer.png"  onclick="idS='.$si->getIdS().'"/>
                <span class="nbsoutiens"> '.$si->getNSoutienS().'</span>
                </div>
              </div> </div>';
          }
  				$tabLatLng = $siMa->getTabLatLng();?>
        </div>
        <div class="Désincription">
          <h3 class="title-account2">Se désincrire</h3>
          <button class="seDesinscrire" onclick="email='<?php echo $emailU ?>'" >Se désincrire</button>
        </div>
        <?php if($manageU->isConnected() === true && $_SESSION['confirme']==1){
        ?><script src="monCompteSupprimerS.js"></script>
        <?php } ?>
      </div>
    <div class= "mapcanvas"  id="mapcanvas">
      <?php include( 'monCompteZoom.php');?>
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
