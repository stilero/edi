<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of edinameadress
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiNAD extends EdiElement{
    var $name = 'Name and Adress';
    var $identifier = 'NAD';
    protected $partyQualifier;
    protected $partyId;
    protected $partyIdCode;
    protected $partyIdAgency;
    protected $nameAdress1;
    protected $nameAdress2;
    protected $nameAdress3;
    protected $nameAdress4;
    protected $nameAdress5;
    protected $partyName1;
    protected $partyName2;
    protected $partyName3;
    protected $partyName4;
    protected $partyName5;
    protected $street1;
    protected $street2;
    protected $street3;
    protected $cityName;
    protected $countrySubId;
    protected $postCode;
    protected $countryCode;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->partyQualifier = $this->getSegmentValByKey(1);
        $this->partyId = $this->getSegmentValByKey(2,0);
        $this->partyIdCode = $this->getSegmentValByKey(2,1);
        $this->partyIdAgency = $this->getSegmentValByKey(2,2);
        $this->nameAdress1 = $this->getSegmentValByKey(3,0);
        $this->nameAdress2 = $this->getSegmentValByKey(3,1);
        $this->nameAdress3 = $this->getSegmentValByKey(3,2);
        $this->nameAdress4 = $this->getSegmentValByKey(3,3);
        $this->nameAdress5 = $this->getSegmentValByKey(3,4);
        $this->partyName1 = $this->getSegmentValByKey(4,0);
        $this->partyName2 = $this->getSegmentValByKey(4,1);
        $this->partyName3 = $this->getSegmentValByKey(4,2);
        $this->partyName4 = $this->getSegmentValByKey(4,3);
        $this->partyName5 = $this->getSegmentValByKey(4,4);
        $this->street1 = $this->getSegmentValByKey(5,0);
        $this->street2 = $this->getSegmentValByKey(5,1);
        $this->street3 = $this->getSegmentValByKey(5,2);
        $this->cityName = $this->getSegmentValByKey(6);
        $this->countrySubId = $this->getSegmentValByKey(7);
        $this->postCode = $this->getSegmentValByKey(8);
        $this->countryCode = $this->getSegmentValByKey(9);
    }
    
    public function stringElement(){
        return 
        $this->identifier.'+'.
                $this->partyQualifier.'+'.
        $this->partyId.':'.$this->partyIdCode.':'.$this->partyIdAgency.'+'.
        $this->nameAdress1.':'.$this->nameAdress2.':'.$this->nameAdress3.':'.$this->nameAdress4.':'.$this->nameAdress5.'+'.
        $this->partyName1.':'.$this->partyName2.':'.$this->partyName3.':'.$this->partyName4.':'.$this->partyName5.'+'.
        $this->street1.':'.$this->street2.':'.$this->street3.'+'.
        $this->cityName.'+'.
        $this->countrySubId.'+'.
        $this->postCode.'+'.
        $this->countryCode.'\'';
    }
}

?>
