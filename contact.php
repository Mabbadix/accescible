<?php

//******Connect BD********
require 'connData.php';
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING); // On émet une alerte à chaque fois qu'une requête a échoué.
/***********traitement d'un Signalement en POO*/
$manageU = new UtilisateurManager($bdd);
if($manageU->isConnected() === true){
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
 $mailContact = true;
}
}
 ?>
   <!DOCTYPE html>
  <html lang="fr">

	<div class="popupContact">
			<div class="pageContact">
				<span id="crossContact">X</span>
				<h2 id="titleContact">Nous contacter</h2>
	        <form class="formContact" method="POST" action=#>
	          <label for="message">Remplir le formulaire svp</label><br/>
	          <label data-for="Courriel"></label><input class="champsContact" id="courrielContact" type="email" name="emailF" <?php if($connu){{echo 'value='.$recupEmail;}} ?> placeholder="dupont@gmail.com" required maxlength="100"><br/>
	          <textarea class="champsContact" id="message" name="message" rows="10" cols="20" placeholder="VOTRE MESSAGE ICI" required ></textarea><br/><br/>
	          <button type="submit" name="submit" id="doigtContact"><img id="doigtContactImg" src="img/doigt.svg" alt="Doigt" ></button>
      		</form>
			</div>
	</div>


    <script>
$(document).ready(function(){
  $("#notif").fadeOut(5000);
});

$("#nousContacter").click(function(){
    $(".popupContact").fadeIn("fast", function(){
    });
});

$("#crossContact").click(function(){
    $(".popupContact").fadeOut("fast", function(){

    });
});

var height = $("body").height();
$(".popupContact").height(height);
</script>
