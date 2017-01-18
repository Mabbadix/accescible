<?php
//ouverture de session
session_start();
require 'connData.php';
require 'UtilisateurManager.php';
require 'Utilisateur.php';
$manageU = new UtilisateurManager($bdd);
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
<div id="notif" class="success">
  <h2>Votre message a bien été envoyé</h2>
</div>
<?php
}
}
 ?>
   <!DOCTYPE html>
  <html lang="fr">

  <head>
    <!-- integration de toutes les metas et autres link
				ATTENTION link styleUser.css different du "style.css" -->
    <?php include 'headUtilisateur.php'; ?>
      <title>Acces'Cible-Carte_Utilisateur</title>
  </head>
  <body>
    <header>
			<div class="navFix">
				<!-- Nav Bar + Sidebar -->
	      <!-- ATTENTION headerNav different pour chaque page pour selection du bon onglet" -->
	      <?php include 'headerNavUserCarte.php'; ?>
			</div>
    </header>
    <main>
    <div class="mainUserCarte">
      <h3 class="title-page">Contact</h3>
    <form method="POST" action="#">
      <label for="emailF">Votre email:</label><br>
      <input type="text" name="emailF" value=""><br>
      <label for="message">Votre message:</label><br>
      <textarea name="message" rows="20" cols="40"></textarea><br>
      <input type="submit" name="submit" value="Envoyer">
    </form>
    <div >
          <?php include'test.php';?>
    </div>
    </main>
        <?php include( 'footer.php');?>
        <script>
$(document).ready(function(){
  $("#notif").fadeOut(5000);
});
</script>
  </body>
