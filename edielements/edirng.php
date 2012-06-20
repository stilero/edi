<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of edimeasurements
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */

require_once 'edielement.php';

class EdiRNG extends EdiElement{
    var $name = 'Range Details';
    var $identifier = 'RNG';
    protected $qualifier;
    protected $range;
    protected $rangeMeaUnitCode;
    protected $rangeMin;
    protected $rangeMax;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->qualifier = $this->getSegmentValByKey(1);
        $this->range = $this->getSegmentValByKey(2,0);
        $this->rangeMeaUnitCode = $this->getSegmentValByKey(2,1);
        $this->rangeMin = $this->getSegmentValByKey(2,2);
        $this->rangeMax = $this->getSegmentValByKey(2,3);
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->qualifier.'+'.
            $this->range.':'.$this->rangeMeaUnitCode.':'.$this->rangeMin.':'.$this->rangeMax.'\'';
    }
}

?>
