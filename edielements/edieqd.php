<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ediequipmentdetails
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiEQD extends EdiElement{
    var $name = 'Equipment Details';
    var $identifier = 'EQD';
    protected $eqQualifier;
    protected $eqId;
    protected $eqIdCode;
    protected $eqIdAgency;
    protected $eqIdCountryCode;
    protected $eqSizeTypeId;
    protected $eqSizeTypeQual;
    protected $eqSizeTypeAgency;
    protected $eqSizeType;
    protected $eqFullEmpty;
    protected $fullEmptyCode = array(
        '1' =>  'More than one quarter volume available',
        '2' =>  'More than half volume available',
        '3' =>  'More than three quarters volume available',
        '4' =>  'Empty',
        '5' =>  'Full'
    );


    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->eqQualifier = $this->getSegmentValByKey(1);
        $this->eqId = $this->getSegmentValByKey(2);
        $this->eqSizeTypeId = $this->getSegmentValByKey(3);
        $this->eqFullEmpty = $this->getSegmentValByKey(6);
    }
    
    public function fullEmptyCodeToText(){
        return $this->fullEmptyCode[$this->eqFullEmpty];
    }
        
    public function stringElement(){
            return $this->arrayToString().'\'';
    }
        
    public function getArray(){
        $this->segmentsArray = array(
            $this->identifier,
            $this->eqQualifier,
            array(
                $this->eqId,
                $this->eqIdAgency,
                $this->eqIdCountryCode
            ),
            array(
                $this->eqSizeTypeId,
                $this->eqSizeTypeQual,
                $this->eqSizeTypeAgency,
                $this->eqSizeType
            ),
            '',
            '',
            $this->eqFullEmpty
        );
        return $this->segmentsArray;
    }}

?>
