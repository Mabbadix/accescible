<?php
//ouverture de session
header( 'content-type: text/html; charset=utf-8' );
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
/***********traitement d'un Signalement en POO*/
$manageU = new UtilisateurManager($bdd);
if($manageU->isConnected() === true && $_SESSION['confirme']==1){
  $recupEmail =  $_SESSION['emailU'];
  $connu = true;
  };

if(isset($_POST['emailF']) and isset($_POST['message'])){
    $emailF = htmlspecialchars($_POST['emailF']);
    $message = htmlspecialchars($_POST['message']);
    require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    $dMail = new PHPMailer;
    $dMail->isSMTP();
    $dMail->Host = 'SSL0.OVH.NET';
    $dMail->SMTPAuth = true;
    $dMail->Username = 'administrateur@projetdev.ovh';
    $dMail->Password = 'Tu10madu1';
    $dMail->SMTPSecure = 'ssl';
    $dMail->Port = 465;
    $dMail->setFrom("$emailF", 'Accescible');
    $dMail->addAddress("loperanes@gmail.com", 'Vous');
    $dMail->isHTML(true);
    $dMail->Subject = 'Message';
    $dMail->Body = "$message";
    $dMail->AltBody = "Bonjour";
if(!$dMail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
    ?>
<?php $mailContact = true;
}
}
 ?>
   <!DOCTYPE html>
  <html lang="fr">

  <head>
    <!-- integration de toutes les metas et autres link
				ATTENTION link styleUser.css different du "style.css" -->
    <?php include 'headUtilisateur.php'; ?>
      <title>Acces'Cible-Nous_contacter</title>
  </head>
  <body>
    <header>
			<div class="navFix">
				<!-- Nav Bar + Sidebar -->
	      <!-- ATTENTION headerNav different pour chaque page pour selection du bon onglet" -->
	      <?php
        $nav_en_cours = 'contact';
        include 'headerNavUserCarte.php'; ?>
			</div>
    </header>
    <main>
    <div class="mainUserCarte">
      <div>
        <form class="formContact" method="POST" action="#">
            <?php if ($mailContact==true) {echo '<div id="notif" class="success"> <h2>Votre message a bien été envoyé</h2></div><script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",1500) </script>';}/*else{echo '<div id="notif" class="success"> <h2>ICI POUR ENVOYER envoyé</h2></div>';}*/?><label class="title-page" for="message">Nous contacter</label><br/><br/>
          <label for="Courriel"></label><input class="champsContact" id="courrielContact" type="email" name="emailF" <?php if($connu){{echo 'value='.$recupEmail;}} ?> placeholder="dupont@gmail.com" required maxlength="100"></input><br/><br/>
          <textarea class="champsContact" id="message" type="text" name="message" rows="20" cols="40" placeholder="VOTRE MESSAGE ICI" required ></textarea><br/><br/>
          <button type="submit" name="submit" value="Envoyer" id="envoyer"><img id="doigt" src="img/doigt.svg" height="80px"></img></button>
        </form>
      </div>
    </main>
    <?php include( 'footer.php');?>
    <script>
$(document).ready(function(){
  $("#notif").fadeOut(5000);
});
</script>
</body>
