<?php
/* Objet utilisateur pour enregistrement et autre"*/
class Utilisateur {
  private $_idU;
  private $_emailU;
  private $_mdpU;
  private $_nomU;
  private $_prenomU;
  private $_adresseU;
  private $_villeU;
  private $_cpU;
  private $_telU;
  private $_dateU;
  private $_signalU;
  private $_valide;

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
        return $this->_idU;
    }

    /**
     * Get the value of Email
     *
     * @return mixed
     */
    public function getEmailU()
    {
        return $this->_emailU;
    }

    /**
     * Get the value of Mdp
     *
     * @return mixed
     */
    public function getMdpU()
    {
        return $this->_mdpU;
    }

    /**
     * Get the value of Nom
     *
     * @return mixed
     */
    public function getNomU()
    {
        return $this->_nomU;
    }

    /**
     * Get the value of Prenom
     *
     * @return mixed
     */
    public function getPrenomU()
    {
        return $this->_prenomU;
    }

    /**
     * Get the value of Adresse
     *
     * @return mixed
     */
    public function getAdresseU()
    {
        return $this->_adresseU;
    }

    /**
     * Get the value of Ville
     *
     * @return mixed
     */
    public function getVilleU()
    {
        return $this->_villeU;
    }

    /**
     * Get the value of Cp
     *
     * @return mixed
     */
    public function getCpU()
    {
        return $this->_cpU;
    }

    /**
     * Get the value of Tel
     *
     * @return mixed
     */
    public function getTelU()
    {
        return $this->_telU;
    }

    /**
     * Get the value of Date
     *
     * @return mixed
     */
    public function getDateU()
    {
        return $this->_dateU;
    }

    /**
     * Get the value of Signal
     *
     * @return mixed
     */
    public function getSignalU()
    {
        return $this->_signalU;
    }

    /**
     * Get the value of Valide
     *
     * @return mixed
     */
    public function getValide()
    {
        return $this->_valide;
    }

  /*****************SETERS**************/

    /**
     * Set the value of Id
     *
     * @param mixed _idU
     *
     * @return self
     */
    public function setIdU($_idU)
    {
        $this->_idU = $_idU;

        return $this;
    }

    /**
     * Set the value of Email
     *
     * @param mixed _emailU
     *
     * @return self
     */
    public function setEmailU($_emailU)
    {
        $this->_emailU = $_emailU;

        return $this;
    }

    /**
     * Set the value of Mdp
     *
     * @param mixed _mdpU
     *
     * @return self
     */
    public function setMdpU($_mdpU)
    {
        $this->_mdpU = $_mdpU;

        return $this;
    }

    /**
     * Set the value of Nom
     *
     * @param mixed _nomU
     *
     * @return self
     */
    public function setNomU($_nomU)
    {
        $this->_nomU = $_nomU;

        return $this;
    }

    /**
     * Set the value of Prenom
     *
     * @param mixed _prenomU
     *
     * @return self
     */
    public function setPrenomU($_prenomU)
    {
        $this->_prenomU = $_prenomU;

        return $this;
    }

    /**
     * Set the value of Adresse
     *
     * @param mixed _adresseU
     *
     * @return self
     */
    public function setAdresseU($_adresseU)
    {
        $this->_adresseU = $_adresseU;

        return $this;
    }

    /**
     * Set the value of Ville
     *
     * @param mixed _villeU
     *
     * @return self
     */
    public function setVilleU($_villeU)
    {
        $this->_villeU = $_villeU;

        return $this;
    }

    /**
     * Set the value of Cp
     *
     * @param mixed _cpU
     *
     * @return self
     */
    public function setCpU($_cpU)
    {
        $this->_cpU = $_cpU;

        return $this;
    }

    /**
     * Set the value of Tel
     *
     * @param mixed _telU
     *
     * @return self
     */
    public function setTelU($_telU)
    {
        $this->_telU = $_telU;

        return $this;
    }

    /**
     * Set the value of Date
     *
     * @param mixed _dateU
     *
     * @return self
     */
    public function setDateU($_dateU)
    {
        $this->_dateU = $_dateU;

        return $this;
    }

    /**
     * Set the value of Signal
     *
     * @param mixed _signalU
     *
     * @return self
     */
    public function setSignalU($_signalU)
    {
        $this->_signalU = $_signalU;

        return $this;
    }

    /**
     * Set the value of Valide
     *
     * @param mixed _valide
     *
     * @return self
     */
    public function setValide($_valide)
    {
        $this->_valide = $_valide;

        return $this;
    }

}


 ?>
