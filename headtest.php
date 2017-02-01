  <header class="header">
    <a href="#" class="header__icon" id="header__icon">
      <button class="hamburger hamburger--emphatic" id="hamburger" type="button">
        <span class="hamburger-box">
          <span class="hamburger-inner"></span>
        </span>
      </button>
    </a>
    <a href="#" class="header__logo"><img src="img/logo7.png"></a>
    <nav class="menu">
      <a href="userCarte.php">Carte</a>
      <a href="signaler.php">Signaler</a>
      <a href="#" id="account">Mon compte</a>
      <a href="#" id="nousContacter">Contact</a>
      <a href="deconn.php">Déconnection</a>
    </nav>
  </header>
<?php 
include'contact.php';
if ($mailContact==true) {echo '<div id="notif" class="notif success"> <h2>Votre message a bien été envoyé</h2></div>';}
?>
<?php include'compte.php';?>
<script>
  $(document).ready(function(){
    $("#notif").fadeOut(5000);
  });
</script>