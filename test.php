
        <div class="compte">
            <div class="compte-form">
      <h3 class="title-account">Mon compte</h3>
    <form method="POST" action="compte.php">
      <label for="nomU">Votre nom:</label><br>
      <input class="champsContact" type="text" name="nomU" value=""><br>
      <label for="prenomU">Votre prenom:</label><br>
      <input class="champsContact" type="text" name="prenomU" value=""><br>
      <label for="adresseU">Votre adresse:</label><br>
      <input class="champsContact" type="text" name="adresseU" value=""><br>
      <label for="villeU">Votre ville:</label><br>
      <input class="champsContact" type="text" name="villeU" value=""><br>
      <label for="cpU">Votre code postal:</label><br>
      <input class="champsContact" type="text" name="cpU" value=""><br>
      <label for="telU">Votre numéro de teléphone:</label><br>
      <input class="champsContact" type="text" name="telU" value=""><br>
       <button type="submit" name="submit" value="Envoyer" id="envoyer"><img id="doigt" src="img/doigt.svg" height="80px"></img></button>
    </form>        
    </div>
    <script>
        $("#account").click(function(){
            $(".compte").fadeIn("fast", function(){
            });
        });
        var height = $("body").height();
        $(".compte").height(height);
    </script>
