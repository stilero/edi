<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of messagelocation
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiLOC extends EdiElement {
    var $name = 'Place / Location id';
    var $identifier = 'LOC';
    public $locQualifier;
    public $locId;
    public $locIdCode;
    public $locIdAgency;
    public $placeLocation;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->locQualifier = $this->getSegmentValByKey(1);
        $this->locId = $this->getSegmentValByKey(2,0);
        $this->locIdCode = $this->getSegmentValByKey(2,1);
        $this->locIdAgency = $this->getSegmentValByKey(2,2);
        $this->placeLocation  = $this->getSegmentValByKey(2,3);
    }
    
    public function stringElement(){
        return $this->identifier.'+'.
                $this->locQualifier.'+'.
                $this->locId.':'.$this->locIdCode.':'.$this->locIdAgency.
                //'+'.$this->placeLocation.
                '\'';
    }
}

?>
