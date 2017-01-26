<?php
/* Objet utilisateur pour enregistrement et autre*/
class Utilisateur {
  protected $idU;
  protected $emailU;
  protected $mdpU;
  protected $nomU;
  protected $prenomU;
  protected $adresseU;
  protected $villeU;
  protected $cpU;
  protected $telU;
  protected $dateU;
  protected $signalU;
  protected $valide;
  protected $confirmKey;
  protected $confirme;
  protected $admin;

  /************Constructeur***************/
  public function __construct(array $donnees)
  {
    $this->hydrate($donnees);
  }

  /************Hydratation****************/

  public function hydrate(array $donnees)
  {
    foreach ($donnees as $key=>$value)
    {
      $method = 'set'.ucfirst($key);
      if (method_exists($this, $method))
      {
        $this->$method($value);
      }
    }
  }

  /*************GETTERS************/
    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getIdU()
    {
        return $this->idU;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmailU()
    {
        return $this->emailU;
    }

    /**
     * Get the value of Mdp
     *
     * @return mixed
     */
    public function getMdpU()
    {
        return $this->mdpU;
    }

    /**
     * Get the value of Nom
     *
     * @return mixed
     */
    public function getNomU()
    {
        return $this->nomU;
    }

    /**
     * Get the value of Prenom
     *
     * @return mixed
     */
    public function getPrenomU()
    {
        return $this->prenomU;
    }

    /**
     * Get the value of Adresse
     *
     * @return mixed
     */
    public function getAdresseU()
    {
        return $this->adresseU;
    }

    /**
     * Get the value of Ville
     *
     * @return mixed
     */
    public function getVilleU()
    {
        return $this->villeU;
    }

    /**
     * Get the value of Cp
     *
     * @return mixed
     */
    public function getCpU()
    {
        return $this->cpU;
    }

    /**
     * Get the value of Tel
     *
     * @return mixed
     */
    public function getTelU()
    {
        return $this->telU;
    }

    /**
     * Get the value of Date
     *
     * @return mixed
     */
    public function getDateU()
    {
        return $this->dateU;
    }

    /**
     * Get the value of Signal
     *
     * @return mixed
     */
    public function getSignalU()
    {
        return $this->signalU;
    }

    /**
     * Get the value of Valide
     *
     * @return mixed
     */
    public function getValide()
    {
        return $this->valide;
    }

    /**
    * Get the value of confirmKey
    *
    * @return mixed
    */
    public function getConfirmKey()
    {
        return $this->confirmKey;
    }

    /**
    * Get the value of confirme
    *
    * @return mixed
    */
    public function getConfirme()
    {
        return $this->confirme;
    }

    /**
    * Get the value of admin
    * 
    * @return mixed
    */
    public function getAdmin()
    {
        return $this->confirme;
    }

  /*****************SETERS**************/

    /**
     * Set the value of Id
     *
     * @param mixed idU
     *
     * @return self
     */
    public function setIdU($idU)
    {
        $this->idU = $idU;

        return $this;
    }

    /**
     * Set the value of Email
     *
     * @param mixed emailU
     *
     * @return self
     */
    public function setEmailU($emailU)
    {
        $this->emailU = $emailU;

        return $this;
    }

    /**
     * Set the value of Mdp
     *
     * @param mixed mdpU
     *
     * @return self
     */
    public function setMdpU($mdpU)
    {
        $this->mdpU = $mdpU;

        return $this;
    }

    /**
     * Set the value of Nom
     *
     * @param mixed nomU
     *
     * @return self
     */
    public function setNomU($nomU)
    {
        $this->nomU = $nomU;

        return $this;
    }

    /**
     * Set the value of Prenom
     *
     * @param mixed _prenomU
     *
     * @return self
     */
    public function setPrenomU($prenomU)
    {
        $this->prenomU = $prenomU;

        return $this;
    }

    /**
     * Set the value of Adresse
     *
     * @param mixed _adresseU
     *
     * @return self
     */
    public function setAdresseU($adresseU)
    {
        $this->adresseU = $adresseU;

        return $this;
    }

    /**
     * Set the value of Ville
     *
     * @param mixed villeU
     *
     * @return self
     */
    public function setVilleU($villeU)
    {
        $this->villeU = $villeU;

        return $this;
    }

    /**
     * Set the value of Cp
     *
     * @param mixed cpU
     *
     * @return self
     */
    public function setCpU($cpU)
    {
        $this->cpU = $cpU;

        return $this;
    }

    /**
     * Set the value of Tel
     *
     * @param mixed telU
     *
     * @return self
     */
    public function setTelU($telU)
    {
        $this->telU = $telU;

        return $this;
    }

    /**
     * Set the value of Date
     *
     * @param mixed dateU
     *
     * @return self
     */
    public function setDateU($dateU)
    {
        $this->dateU = $dateU;

        return $this;
    }

    /**
     * Set the value of Signal
     *
     * @param mixed signalU
     *
     * @return self
     */
    public function setSignalU($signalU)
    {
        $this->signalU = $signalU;

        return $this;
    }

    /**
     * Set the value of Valide
     *
     * @param mixed valide
     *
     * @return self
     */
    public function setValide($valide)
    {
        $this->valide = $valide;

        return $this;
    }

    /**
     * Set the value of confirmKey
     *
     * @param mixed confirmKey
     *
     * @return self
     */
    public function setConfirmKey($confirmKey)
    {
        $this->confirmKey = $confirmKey;
        return $this;
    }

    /**
     * Set the value of confirme
     *
     * @param mixed confirme
     *
     * @return self
     */
    public function setConfirme($confirme)
    {
      $this->confirme = $confirme;
      return $this;
    }

    /**
    * Set the value of confirme
    *
    * @param mixed confirme
    *
    * @return self
    */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
        return $this;
    }

}

?>
