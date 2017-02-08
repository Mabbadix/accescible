<?php
//vérfication si la personne est connectée : si oui accès à l'espace des inscrits, sinon accès espace restreint
if($manageU->isConnected() === true && $_SESSION['confirme']==1){
  ?>
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
      <a href="monCompteBis.php" id="account">Mon compte</a>
      <a href="#" id="nousContacter">Contact</a>
      <a href="deconn.php">Déconnection</a>
    </nav>
  </header>
<?php
include'pageContact.php';
if ($mailContact==true) {echo '<div id="notif" class="notif success"> <h2>Votre message a bien été envoyé</h2></div>';}
?>
<script>
  $(document).ready(function(){
    $("#notif").fadeOut(5000);
  });
</script>
<?php }elseif ($manageU->isConnected()=== true && $_SESSION['confirme'] == 0){?>
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
      <a href="monCompteBis.php" id="account">Mon compte</a>
      <a href="#" id="nousContacter">Contact</a>
      <a href="deconn.php">Déconnection</a>
    </nav>
  </header>
<?php
include'pageContact.php';
if ($mailContact==true) {echo '<div id="notif" class="notif success"> <h2>Votre message a bien été envoyé</h2></div>';}
?>
<script>
  $(document).ready(function(){
    $("#notif").fadeOut(5000);
  });
</script>
<?php }else{
?>
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
      <a href="index.php" id="account">Sign in/up </a>
      <a href="#" id="nousContacter">Contact</a>
  </header>
  <?php
  include'pageContact.php';
  if ($mailContact==true) {echo '<div id="notif" class="notif success"> <h2>Votre message a bien été envoyé</h2></div>';}
  ?>
  <script>
    $(document).ready(function(){
      $("#notif").fadeOut(5000);
    });
  </script>
<?php
} ?>
