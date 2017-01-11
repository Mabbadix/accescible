<?php
/* Objet utilisateur pour enregistrement et autre"*/
class Signalement{
  /***Var de localisation du pb****/
protected $signalPar;
protected $adresseS;
protected $villeS;
protected $cpS;
protected $regionS;
protected $paysS;
protected $latlng;
protected $placeId;
protected $photoS;
protected $dateS;

/**********Var relatives à l'état du S**************/
protected $resoluS;
protected $interventionS;
protected $nSoutienS;

/*****Var type de problème*****/
protected $typeS;
protected $descriptionS;


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

    public function getSignalPar()
    {
        return $this->signalPar;
    }

    public function getAdresseS()
    {
        return $this->adresseS;
    }


    public function getCpS()
    {
        return $this->cpS;
    }

    /**
     * Get the value of villeS
     *
     * @return mixed
     */
    public function getVilleS()
    {
        return $this->villeS;
    }

    /**
     * Get the value of regionS
     *
     * @return mixed
     */
    public function getRegionS()
    {
        return $this->regionS;
    }

    /**
     * Get the value of paysS
     *
     * @return mixed
     */
    public function getPaysS()
    {
        return $this->paysS;
    }

    /**
     * Get the value of latlng
     *
     * @return mixed
     */
    public function getLatlng()
    {
        return $this->latlng;
    }

    /**
     * Get the value of placeId
     *
     * @return mixed
     */
    public function getPlaceId()
    {
        return $this->placeId;
    }

    /**
     * Get the value of typeS
     *
     * @return mixed
     */
    public function getTypeS()
    {
        return $this->typeS;
    }

    /**
     * Get the value of descriptionS
     *
     * @return mixed
     */
    public function getDescriptionS()
    {
        return $this->descriptionS;
    }

    /**
     * Get the value of Date
     *
     * @return mixed
     */
    public function getDateS()
    {
        return $this->dateS;
    }

    /**
     * Get the value of photoS
     *
     * @return mixed
     */
    public function getPhotoS()
    {
        return $this->photoS;
    }

    /**
     * Get the value of resoluS
     *
     * @return mixed
     */
    public function getResoluS()
    {
        return $this->resoluS;
    }

    public function getInterventionS()
    {
        return $this->interventionS;
    }
    public function getNSoutienS()
    {
        return $this->nSoutienS;
    }
  /*****************SETTERS**************/
  /**
   * Set the value of signalPar
   *
   * @return mixed
   */
  public function setSignalPar($signalPar)
  {
      $this->signalPar = $signalPar ;
      return $this;
  }

  public function setAdresseS($adresseS)
  {
      $this->adresseS = $adresseS ;
      return $this;
  }

  /**
   * Set the value of cpS
   *
   * @return mixed
   */
  public function setCpS($cpS)
  {
      $this->cpS = $cpS ;
      return $this;
  }

  /**
   * Set the value of villeS
   *
   * @return mixed
   */
  public function setVilleS($villeS)
  {
      $this->villeS = $villeS ;
      return $this;
  }

  /**
   * Set the value of regionS
   *
   * @return mixed
   */
  public function setRegionS($regionS)
  {
      $this->regionS = $regionS ;
      return $this;
  }

  /**
   * Set the value of paysS
   *
   * @return mixed
   */
  public function setPaysS($paysS)
  {
      $this->paysS = $paysS ;
      return $this;
  }

  /**
   * Set the value of latlng
   *
   * @return mixed
   */
  public function setLatlng($latlng)
  {
      $this->latlng = $latlng ;
      return $this;
  }

  /**
   * Set the value of placeId
   *
   * @return mixed
   */
  public function setPlaceId($placeId)
  {
      $this->placeId = $placeId ;
      return $this;
  }

  /**
   * Set the value of typeS
   *
   * @return mixed
   */
  public function setTypeS($typeS)
  {
      $this->typeS = $typeS ;
      return $this;
  }

  /**
   * Set the value of descriptionS
   *
   * @return mixed
   */
  public function setDescriptionS($descriptionS)
  {
      $this->descriptionS = $descriptionS ;
      return $this;
  }

  /**
   * Set the value of Date
   *
   * @return mixed
   */
  public function setDateS($dateS)
  {
      $this->dateS = $dateS ;
      return $this;
  }

  /**
   * Set the value of photoS
   *
   * @return mixed
   */
  public function setPhotoS($photoS)
  {
      $this->photoS = $photoS ;
      return $this;
  }

  /**
   * Set the value of resoluS
   *
   * @return mixed
   */
  public function setResoluS($resoluS)
  {
      $this->resoluS = $resoluS ;
      return $this;
  }

  public function setInterventionS($interventionS)
  {
      $this->interventionS = $interventionS ;
      return $this;
  }
  public function setNSoutienS($nSoutienS)
  {
      $this->nSoutienS = $nSoutienS ;
      return $this->nSoutienS;
  }
}

?>
