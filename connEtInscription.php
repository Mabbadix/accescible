/*connexionEtInscription*/

<?php
  header('content-type: text/html; charset=utf-8');
  //******Connect BD********
  require 'connData.php';

    //On récupère les infos saisies
  $Courriel = htmlspecialchars($_POST['Courriel']);
  $Mdp = sha1($_POST['Mot_de_passe']);
  // On compare avec infos de la Bd
    //Configuration pour selectionner Utilisateur dans la bd
  $SelectU = $bdd->prepare("SELECT idU, emailU, mdpU, valide FROM utilisateur WHERE emailU = '$Courriel'
    AND mdpU='$Mdp'");
  $SelectU->execute();
    //Interogation de la Bd

  $RetourBd = $SelectU->rowCount();
        //Si aucune correspondance : info + redirection inscription
        //on met les données recupérées dans un tableau
  $result = $SelectU->fetch();

  /**********SI SE CONNECTER*************/

  if (isset($_POST['se_connecter'])) {
      //si compte n'existe pas
      if ($RetourBd == 0) {
          echo "<script language='JavaScript' type='text/javascript'>";
          echo 'alert("Aucun compte ne correspond à ces données ! Inscrivez-vous ou verifiez votre saise. Merci");';
          echo 'history.back(-1)';
          echo '</script>';
      }
        //Si 1 correspondance
      elseif ($RetourBd == 1) {
          //On verfie que pas banni
        if ($result['valide'] == 1) {
            //on verifie que compte n'est pas banni avec la donnée "valide" dela bd
          echo "<script language='JavaScript' type='text/javascript'>";
            echo 'alert("Votre compte a été bloqué");';
            echo 'history.back(-1)';
            echo '</script>';
        }
        // Sinon on accede au compte
        else {
            //on créer la session
          $_SESSION['emailU'] = $result['emailU'];
          $_SESSION['mdpU'] = $result['mdpU'];
          //on redirige
          echo '<div id="ok">Connexion réussie. Redirection en cours...</div>
          <script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",500) </script>';
        }
      }
  }

  /**********SI CLIQUE S'INSCRIRE*************/
  if (isset($_POST['boutInscription'])) {
      //On vérifie que compte existe et si c'est le cas idem que "connexion"
    if ($RetourBd == 1) {
        //on verifie que compte n'est pas banni avec la donnée "valide" dela bd
      if ($result['valide'] == 1) {
          echo "<script language='JavaScript' type='text/javascript'>";
          echo 'alert("Votre compte a été bloqué, vous ne pouvez vous réinscrire!");';
          echo 'history.back(-1)';
          echo '</script>';
      } else {
          //on créer la session
        $_SESSION['emailU'] = $result['emailU'];
        $_SESSION['mdpU'] = $result['mdpU'];
        //on redirige
          echo '<div id="ok">Connexion réussie. Redirection en cours GGG...</div>
          <script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",500) </script>';
      }
    }
    //Si 0 correspondance = aucun compte normalement
    elseif ($RetourBd == 0) {

      //on vérifie toutefois que email n'est pas utilisé avec un autre mot passe
      $SelectMailU = $bdd->prepare("SELECT idU, emailU, valide FROM utilisateur WHERE emailU = '$Courriel'");
        $SelectMailU->execute();
        //Retour de la bd sur le num de ligne correspondante
      $RetourMailUBd = $SelectMailU->rowCount();
      //on met les données recupérées dans un tableau
      $resultMailU = $SelectMailU->fetch();

        if ($RetourMailUBd == 1) {
            //on verifie que l'email n'est pas banni avec la donnée "valide" dela bd et que tentative réinscription avec un autre mdp
          if ($resultMailU['valide'] == 1) {
            echo "<script language='JavaScript' type='text/javascript'>";
            echo 'alert("Ce compte a été bloqué, vous ne pouvez vous réinscrire avec un autre mot de passe!");';
            echo 'history.back(-1)';
            echo '</script>';
          }
        // si email déjà utilisé
          else {
            echo "<script language='JavaScript' type='text/javascript'>";
            echo 'alert("Ce courriel est déjà utilisé! Connectez-vous.");';
            echo 'history.back(-1)';
            echo '</script>';
          }
        } else {
            // date du jour
        $date = date('Y-m-d');
        //enregistrement données saisies
        $insertInscription = $bdd->prepare("INSERT INTO utilisateur (emailU, mdpU, dateU)
        VALUES ('$Courriel','$Mdp','$date')");
            print_r($insertInscription->execute());
        //Si il y a une erreur
        if (!$insertInscription) {
            print($insertInscription->errorInfo());
        } else {
          $_SESSION['emailU'] = $result['emailU'];
          $_SESSION['mdpU'] = $result['mdpU'];
          //on redirige
            echo '<div id="ok">Connexion réussie. Redirection en cours GGG...</div>
            <script type="text/javascript"> window.setTimeout("location=(\'userCarte.php\');",100) </script>';

        }
      }
    }
  }
