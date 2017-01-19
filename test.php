        <div class="compte">
            <div class="compte-form">
      <h3 class="title-page">Mon compte</h3>
    <form method="POST" action="compte.php">
      <label for="nomU">Votre nom:</label><br>
      <input type="text" name="nomU" value=""><br>
      <label for="prenomU">Votre prenom:</label><br>
      <input type="text" name="prenomU" value=""><br>
      <label for="adresseU">Votre adresse:</label><br>
      <input type="text" name="adresseU" value=""><br>
      <label for="villeU">Votre ville:</label><br>
      <input type="text" name="villeU" value=""><br>
      <label for="cpU">Votre code postal:</label><br>
      <input type="text" name="cpU" value=""><br>
      <label for="telU">Votre numéro de teléphone:</label><br>
      <input type="text" name="telU" value=""><br>
      <input type="submit" name="submit" value="Envoyer">
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
