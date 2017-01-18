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
      $q = $this->_db->prepare("INSERT INTO utilisateur ( emailU, mdpU, nomU, prenomU, adresseU, villeU, cpU, telU, dateU, signalU, valide, confirmKey,  confirme) VALUES( :emailU, :mdpU, :nomU, :prenomU, :adresseU, :villeU, :cpU, :telU, :dateU, :signalU, :valide, :confirmKey, :confirme)");

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
  public function delete(Utilisateur $ut)
  {
    $this->_db->exec('DELETE FROM personnages WHERE id = '.$ut->id());
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
    $q = $this->_db->prepare("SELECT idU, emailU, mdpU, valide FROM utilisateur WHERE emailU = :emailU AND mdpU=:mdpU");
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

  //envoi email à l'aide phpmailer avec cette function : parametre = email de l'utilisateur et la clef créée.
  public function envoieMail($dMailU, $dkey){
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
    $dMail->Body = "Bonjour $dkey";
    $dMail->AltBody = "Bonjour $dkey";
    $dMail->send();
  }

//RESTE A FAIRE
  /*public function update(Utilisateur $ut){
  }

  public function read(Utilisateur $ut){
  }

public function getList($nom)
  {
    $persos = [];

    $q = $this->_db->prepare('SELECT id, nom, degats FROM personnages WHERE nom <> :nom ORDER BY nom');
    $q->execute([':nom' => $nom]);

    while ($donnees = $q->fetch(PDO::FETCH_ASSOC))
    {
      $persos[] = new Personnage($donnees);
    }

    return $persos;
  }

  public function update(Personnage $perso)
  {
    $q = $this->_db->prepare('UPDATE personnages SET degats = :degats WHERE id = :id');

    $q->bindValue(':degats', $perso->degats(), PDO::PARAM_INT);
    $q->bindValue(':id', $perso->id(), PDO::PARAM_INT);

    $q->execute();
  }

  public function setDb(PDO $db)
  {
    $this->_db = $db;
  }*/
}
?>
