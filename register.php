<?php
require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';         //On importe la librairie mail
require 'connData.php';
if (isset($_POST['boutInscription'])) {  //On vérifie qu'il sagit bien du formulaire d'inscription
  $mail = htmlspecialchars($_POST['Courriel']);     //Sécurisation du mail
  $mdp = sha1($_POST['Mot_de_passe']);              //On crypte le mot de passe
  $date = date('Y-m-d');
  echo 'ok';
  if (!empty($_POST['Courriel']) && !empty($_POST['Mot_de_passe'])) {       //Si les champs sont tous rempli
            if (filter_var($mail, FILTER_VALIDATE_EMAIL)) {             //On vérifie que le format de l'adresse mail est correct
              $reqmail = $bdd->prepare('SELECT * FROM utilisateur WHERE emailU = ?');       //On verifie que l'email n'est pas deja utilisé
              $reqmail->execute(array($mail));
              $mailexist = $reqmail->rowCount();
              echo 'ok';
              if ($mailexist == 0) {                       
                  $mdplength = strlen($mdp);
                  if ($mdplength >= 8) {                          //Si le mot de passe a bien 8 ou plus en longueur on passe a l'enregistrement

                    $longueurKey = 15;      // longueur de la clé d'activation
                    $key = "";              // initialisation de la clé

                    for($i = 1;$i < $longueurKey;$i++){
                      $key .= mt_rand(0,9);                     //Genération de la clé
                    }
                    echo 'ok';
                                    /*   Genération du mail de confirmation grace a PHPMailer    */

                    $confirmMail = new PHPMailer;
                    $confirmMail->isSMTP();
                    $confirmMail->Host = 'SSL0.OVH.NET';
                    $confirmMail->SMTPAuth = true;
                    $confirmMail->Username = 'administrateur@projetdev.ovh';
                    $confirmMail->Password = 'Tu10madu1';
                    $confirmMail->SMTPSecure = 'ssl';
                    $confirmMail->Port = 465;
                    echo 'ok';
                    $confirmMail->setFrom('Accescible@noreply.org', 'Accescible');
                    $confirmMail->addAddress("$mail",'Vous');
                    $confirmMail->isHTML(true);

                    $confirmMail->Subject = 'Votre inscription a Accescible';
                    $confirmMail->Body = 'Bonjour,<br />Pour confirmer votre inscription a Accescible veuillez cliquez sur le lien suivant <a href="projetdev.ovh/accescible/activation?key='.$key.'">ICI</a>';
                    echo 'okSS';
                    print_r($mail);
                    if(!$confirmMail->send()) {
                      /*echo 'Message could not be sent.';
                      echo 'Mailer Error: ' . $mail->ErrorInfo;*/
                      echo 'bite';
                    } else {
                      echo 'Message has been sent';
                    }
                    echo 'ok';
                    $insertmbr = $bdd->prepare('INSERT INTO utilisateur(emailU, mdpU, dateU, validationKey) VALUES(?, ?, ?, ?)');
                    $insertmbr->execute(array($mail, $mdp, $date, $key));


                    echo 'Votre compte a bien été créé ! <a href="connexion.php">Me connecter</a>' ;
                  }else {
                    echo 'Votre mot de passe doit faire un minimum de 8 caracteres.' ;
                  }
              } else {
                echo 'Adresse mail déjà utilisée !' ;
              }
            } else {
              echo "Votre adresse mail n'est pas valide !" ;
            }
          } else {
            echo 'Vos adresses mail ne correspondent pas !' ;
          }
  }else {
    echo 'Tous les champs doivent être complétés !' ;
    print_r($_POST);
  }
?>
