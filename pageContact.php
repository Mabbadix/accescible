<?php
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
if(!$dMail->send()) {
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
} else {
 $mailContact = true;
}
}
 ?>
	<div class="popup">
			<div class="pageContact popup--inside">
				<span id="crossContact" class="cross">X</span>
				<h2 class="popup--title">Nous contacter</h2>
	        <form class="popup--form" method="POST" action=#>
	          <label for="message">Remplir le formulaire svp</label><br/>
	          <label data-for="Courriel"></label><input class="popup--champs" id="courrielContact" type="email" name="emailF" <?php if($connu){{echo 'value='.$recupEmail;}} ?> placeholder="dupont@gmail.com" required maxlength="100"><br/>
	          <textarea class="popup--champs" id="message" name="message" rows="10" cols="20" placeholder="VOTRE MESSAGE ICI" required ></textarea><br/><br/>
	          <button type="submit" name="submit" id="doigtContact" class="button--circle spin"><img id="doigtContactImg" src="img/doigt.svg" alt="Doigt" ></button>
      		</form>
			</div>
	</div>


    <script>
$(document).ready(function(){
  $("#notif").fadeOut(5000);
});

$("#nousContacter").click(function(){
    $('body').removeClass('with--sidebar');
    $('#hamburger').removeClass('is-active');
    $(".popup").fadeIn("fast", function(){
    });

});

$("#crossContact").click(function(){
    $(".popup").fadeOut("fast", function(){
    });
});


var height = $("body").height();
$(".popup").height(height);
</script>
