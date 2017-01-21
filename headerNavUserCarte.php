<?php
//vérfication si la personne est connectée : si oui accès à l'espace des inscrits, sinon accès espace restreint
if($manageU->isConnected() === true && $_SESSION['confirme']==1){
  ?>
<ul>
  <li><a <?php if ($nav_en_cours == 'usercarte') {echo ' id="active"';} ?> href="userCarte.php">Carte</a></li>
  <li><a <?php if ($nav_en_cours == 'signaler') {echo ' id="active"';} ?> href="signaler.php">Signaler</a></li>
  <li><a href="#side">
    <span id="traitside" onclick="ouvrirNav()">
       ☰ </span></a>
       <!-- side deroulant -->
      <div id="sideBar" class="side">
          <!-- Button to close the overlay navigation -->
          <a href="javascript:void(0)"onclick="fermerNav()" class="boutonFermer">
            X
          </a>
          <!-- Overlay content -->
          <div class="side-contenu">
            <a  href="#" id="account">Mon compte</a>
            <a href="#">Nos valeurs</a>
            <a href="contact.php">Nous contacter</a>
            <a href="deconn.php " >Déconnection </a>
          </div>
      </div>
        <script>
          function ouvrirNav(){
            document.getElementById ("sideBar").style.width = "250px";
          }
          function fermerNav(){
            document.getElementById ("sideBar").style.width ="0";
          }
        </script>
  </li>
</ul>
<?php include'test.php';?>
<?php }elseif ($manageU->isConnected()=== true && $_SESSION['confirme'] == 0){?>
<ul>
  <li><a <?php if ($nav_en_cours == 'usercarte') {echo ' id="active"';} ?> href="userCarte.php">Carte</a></li>
  <li><a href="index.php">Valider votre email</a></li>
  <li><a href="#side">
    <span id="traitside" onclick="ouvrirNav()">
       ☰ </span></a>
       <!-- side deroulant -->
      <div id="sideBar" class="side">
          <!-- Button to close the overlay navigation -->
          <a href="javascript:void(0)"onclick="fermerNav()" class="boutonFermer">
            X
          </a>
          <!-- Overlay content -->
          <div class="side-contenu">
            <a  href="#" id="account">Mon compte</a>
            <a href="#">Nos valeurs</a>
            <a href="contact.php">Nous contacter</a>
            <a href="deconn.php " >Déconnection </a>
          </div>
      </div>
        <script>
          function ouvrirNav(){
            document.getElementById ("sideBar").style.width = "250px";
          }
          function fermerNav(){
            document.getElementById ("sideBar").style.width ="0";
          }
        </script>
  </li>
</ul>
<?php }else{
?>
<ul>
  <li><a <?php if ($nav_en_cours == 'usercarte') {echo ' id="active"';} ?> href="userCarte.php">Carte</a></li>
  <li><a href="index.php">Connexion</a></li>
  <li><a href="#side">
    <span id="traitside" onclick="ouvrirNav()">
       ☰ </span></a>
       <!-- side deroulant -->
      <div id="sideBar" class="side">
          <!-- Button to close the overlay navigation -->
          <a href="javascript:void(0)"onclick="fermerNav()" class="boutonFermer">
            X
          </a>
          <!-- Overlay content -->
          <div class="side-contenu">
            <a href="index.php">Connexion/inscription</a>
            <a href="#">Nos valeurs</a>
            <a href="contact.php">Nous contacter</a>
          </div>
      </div>
        <script>
          function ouvrirNav(){
            document.getElementById ("sideBar").style.width = "250px";
          }
          function fermerNav(){
            document.getElementById ("sideBar").style.width ="0";
          }
        </script>
  </li>
</ul>
<?php } ?>
