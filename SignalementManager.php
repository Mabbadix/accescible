<?php
/*class qui va gérer les queries SQL pour les utilisateurs : CRUD (create, read, update, delete)"*/

class SignalementManager{
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
  public function add(Signalement $si)
    {

      $q = $this->_db->prepare("INSERT INTO signalements ( signalPar, typeS, descriptionS, adresseS, villeS, cpS, regionS, paysS, latlng, placeId, photoS, dateS, resoluS, interventionS, nSoutienS) VALUES( :signalPar, :typeS, :descriptionS, :adresseS, :villeS, :cpS, :regionS, :paysS, :latlng, :placeId, :photoS, :dateS, :resoluS, :interventionS, :nSoutienS)");


      $q->bindValue(':signalPar', $si->getSignalPar());
      $q->bindValue(':typeS', $si->getTypeS());
      $q->bindValue(':descriptionS', $si->getDescriptionS());
      $q->binDValue(':adresseS', $si->getAdresseS());
      $q->bindValue(':villeS', $si->getVilleS());
      $q->bindValue(':cpS', $si->getCpS());
      $q->bindValue(':regionS', $si->getRegionS());
      $q->bindValue(':paysS', $si->getPaysS());
      $q->bindValue(':latlng', $si->getLatlng());
      $q->bindValue(':placeId', $si->getPlaceId());
      $q->bindValue(':photoS', $si->getPhotoS());
      $q->bindValue(':dateS', $si->getDateS());
      $q->bindValue(':resoluS', $si->getResoluS());
      $q->bindValue(':interventionS', $si->getInterventionS());
      $q->bindValue(':nSoutienS', $si->getNSoutienS());

      $q->execute();
      if (!$q)
      {
        print($q->errorInfo());
      }
    }

    //compte le nombre de signalements et le retourne;
  public function count()
  {
    return $this->_db->query('SELECT COUNT(*) FROM signalements')->fetchColumn();
  }

  //supprime un utilisateur; A VERIFIER
  public function delete(Signalement $si)
  {
    $this->_db->exec('DELETE FROM sinalements WHERE latlng = '.$si->getLatlng());
  }

  //verifie si existe et retourne nombre// A VERIFIER
  public function exists($id)
  {
      $q = $this->_db->prepare("SELECT idS FROM signalements WHERE idS =:idS");
      $q->execute([
        ':idS' => $id,
      ]);
      return (bool) $q->fetchColumn();//true or false
  }

    // on renvoi l'ensemble des info utilisateurs
    public function getSignal($id)
    {
      $q = $this->_db->prepare("SELECT * FROM signalements WHERE idS =:id");
      $q->execute([
        ':id' => $id,
      ]);
      return new Signalement ($q->fetch(PDO::FETCH_ASSOC));
    }

    public function getTabLatLng()
    {
      $q = $this->_db->query("SELECT * FROM signalements");
      $check = $q->fetchAll(PDO::FETCH_UNIQUE|PDO::FETCH_ASSOC);
      return $check;
    }

  /*// verif si email déjà utilisé
  public function verifEmailLibre($courriel)
  {
    $q = $this->_db->prepare("SELECT idU, emailU, mdpU, valide FROM utilisateur WHERE emailU = :emailU ");
    $q->execute([':emailU' => $courriel]);
    return (bool) $q->fetchColumn();
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

//RESTE A FAIRE*/
  /*public function update(Utilisateur $si){
  }

  public function read(Utilisateur $si){
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
//ferme la Custom_Image_Header::customize_set_last_used
}

?>
