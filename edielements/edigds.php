<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messagebeginning
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiGDS extends EdiElement{
    var $name = 'Nature of Cargo';
    var $identifier = 'GDS';
    protected $natOfCargo;
    protected $cargoTypeCode;
    protected $codeListIdCode;
    protected $codeListAgencyCode;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->natOfCargo = $this->getSegmentValByKey(1,0);
        $this->cargoTypeCode = $this->getSegmentValByKey(1,1);
        $this->codeListIdCode = $this->getSegmentValByKey(1,2);
        $this->codeListAgencyCode = $this->getSegmentValByKey(1,3);
    }
    
    public function stringElement(){
        return $this->identifier.'+'.
                $this->natOfCargo.':'.$this->cargoTypeCode.':'.$this->codeListIdCode.':'.$this->codeListAgencyCode.
                '\'';
    }
}

?>
