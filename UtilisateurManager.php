<?php
/*class qui va gérer les queries SQL pour les utilisateurs : CRUD (create, read, update, delete)"*/

class UtilisateurManager {
  private $_db;

  public function __construct($db)
  {
    $this ->setDb($db);
  }

  /***Setter db****/

  public function setDb (PDO $db)
  {
    $this->_db =$db;
  }

  /***CRUD***/
  //ajoute un nouvelle utilisateur = inscription
  public function add(Utilisateur $ut)
    {
      $q = $this->_db->prepare("INSERT INTO utilisateur ( emailU, mdpU, nomU, prenomU, adresseU, villeU, cpU, telU, dateU, signalU, valide, confirmKey,  confirme, admin) VALUES( :emailU, :mdpU, :nomU, :prenomU, :adresseU, :villeU, :cpU, :telU, :dateU, :signalU, :valide, :confirmKey, :confirme, :admin)");

      //$q->bindValue(':idU', $ut->getIdU());
      $q->bindValue(':emailU', $ut->getEmailU());
      $q->bindValue(':mdpU', $ut->getMdpU());
      $q->bindValue(':nomU', $ut->getNomU());
      $q->bindValue(':prenomU', $ut->getPrenomU());
      $q->bindValue(':adresseU', $ut->getAdresseU());
      $q->bindValue(':villeU', $ut->getVilleU());
      $q->bindValue(':cpU', $ut->getCpU());
      $q->bindValue(':telU', $ut->getTelU());
      $q->bindValue(':dateU', $ut->getDateU());
      $q->bindValue(':signalU', $ut->getSignalU());
      $q->bindValue(':valide', $ut->getValide());
      $q->bindValue(':confirmKey', $ut->getConfirmKey());
      $q->bindValue(':confirme', $ut->getConfirme());
      $q->bindValue(':admin', $ut->getAdmin());

      $q->execute();
      if (!$q)
      {
        print($q->errorInfo());
      }
      else
      {
        /*echo "<script language='JavaScript' type='text/javascript'>";
        echo 'alert("BIENVENUE ! Connectez-vous");';
        echo 'history.back(-1)';
        echo '</script>';*/
      }
    }

    //compte le nombre d'utilisateurs et le retourne;
  public function count()
  {
    return $this->_db->query('SELECT COUNT(*) FROM utilisateur')->fetchColumn();
  }

  //supprime un utilisateur;
  public function delete($email)
  {
    $q = $this->_db->prepare("DELETE FROM utilisateur WHERE emailU= :emailU");
    $q->execute([':emailU'=>$email]);
  }

  //verifie si existe
  public function exists($courriel, $mdp)
  {

    $q = $this->_db->prepare("SELECT idU, emailU, mdpU, valide FROM utilisateur WHERE emailU = :emailU AND mdpU=:mdpU");
    $q->execute([
      ':emailU' => $courriel,
      ':mdpU' => $mdp
    ]);
  return (bool) $q->fetchColumn();
  }

  // verif si email déjà utilisé
  public function verifEmailLibre($courriel)
  {
    $q = $this->_db->prepare("SELECT idU, emailU, mdpU, valide FROM utilisateur WHERE emailU = :emailU ");
    $q->execute([':emailU' => $courriel]);
    return (bool) $q->fetchColumn();
  }

  // on renvoi l'ensemble des info utilisateurs
  public function getUtilisateur($courriel, $mdp)
  {
    $q = $this->_db->prepare("SELECT idU, emailU, mdpU, nomU, prenomU, adresseU, villeU, cpU, telU, valide, confirme, admin FROM utilisateur WHERE emailU = :emailU AND mdpU=:mdpU");
    $q->execute([
      ':emailU' => $courriel,
      ':mdpU' => $mdp
    ]);
    return new Utilisateur ($q->fetch(PDO::FETCH_ASSOC));
  }

  //vérification de la connection établie pour redirection des pages
  public function isConnected()
  {
    if(isset($_SESSION['logged'])&&($_SESSION['logged'] === true)){
      return true;
    }else{
      return false;
    }
  }

  public function isAdmin($mail)
  {
    $q = $this->_db->prepare("SELECT admin FROM utilisateur WHERE emailU = :emailU");
    $q->execute([':emailU' => $mail]);
    return $q->fetch();
  }

public function isConfirme()
{
  $q = $this->_db->prepare("SELECT confirme FROM utilisateur WHERE emailU = :emailU");
  $q->execute([
  ':emailU' => $_SESSION['emailU']
  ]);
print_r($_SESSION);
}

  //envoi email à l'aide phpmailer avec cette function : parametre = email de l'utilisateur et la clef créée.
  public function envoieMail($dMailU, $dkey)
  {
    require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';
    $dMail = new PHPMailer;
    $dMail->isSMTP();
    $dMail->Host = 'SSL0.OVH.NET';
    $dMail->SMTPAuth = true;
    $dMail->Username = 'administrateur@projetdev.ovh';
    $dMail->Password = 'Tu10madu1';
    $dMail->SMTPSecure = 'ssl';
    $dMail->Port = 465;
    $dMail->setFrom('Accescible@noreply.org', 'Accescible');
    $dMail->addAddress("$dMailU", 'Vous');
    $dMail->isHTML(true);
    $dMail->Subject = 'Validation du compte Accescible';
    $dMail->Body = 'Bienvenue dans la communté Accès\'Cible. Confirmez votre inscriptiion en cliquant <a href="projetdev.ovh/accescible/verifmail.php?key='.$dkey.'&mail='.$dMailU.'">ICI</a>. Merci.';
    $dMail->AltBody = "Bonjour $dkey";
    $dMail->send();
  }

  //Si les infos sont exact passe la confirmation a TRUE
  public function verifEmail($key)
  {
    $q = $this->_db->prepare("UPDATE `utilisateur` SET `confirme`=1 WHERE `confirmKey` = :key");
    $q->execute([':key' => $key]);
  }

  public function updateUtilisateur($mail, $nom, $prenom, $adresse, $ville, $cp, $tel)
  {
    $q = $this->_db->prepare('UPDATE `utilisateur`
                              SET `nomU` = :nomU,
                              `prenomU`  = :prenomU,
                              `adresseU` = :adresseU,
                              `villeU`   = :villeU,
                              `cpU`      = :cpU,
                              `telU`     = :telU WHERE `emailU` = :emailU');
    $q->execute([':nomU' => $nom,
                 ':prenomU' => $prenom,
                 ':adresseU' => $adresse,
                 ':villeU' => $ville,
                 ':cpU' => $cp,
                 ':telU' => $tel,
                 ':emailU' => $mail]);
  }
}
?>
