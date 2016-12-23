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
  public function add(Utilisateur $ut)

    {
      $q = $this->_db->prepare("INSERT INTO utilisateur ( emailU, mdpU, nomU, prenomU, adresseU, villeU, cpU, telU, dateU, signalU, valide) VALUES( :emailU, :mdpU, :nomU, :prenomU, :adresseU, :villeU, :cpU, :telU, :dateU, :signalU, :valide)");

      /*$q->bindValue(':idU', $ut->getIdU());*/
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

      $q->execute();
      if (!$q) {
        print($q->errorInfo());
      } else {
        echo "<script language='JavaScript' type='text/javascript'>";
        echo 'alert("BIENVENUE ! Connectez-vous");';
        echo 'history.back(-1)';
        echo '</script>';
      }
    }
}


 ?>
