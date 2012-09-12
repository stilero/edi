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

class EdiMEA extends EdiElement{
    var $name = 'Measurements';
    var $identifier = 'MEA';
    protected $qualifier;
    protected $details;
    protected $detailsDimension;
    protected $detailsSignificance;
    protected $detailsAttrCoded;
    protected $detailsAttr;
    protected $unit;
    protected $value;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->qualifier = $this->getSegmentValByKey(1);
        $this->details = $this->getSegmentValByKey(2,0);
        $this->detailsDimension = $this->getSegmentValByKey(2,1);
        $this->detailsSignificance = $this->getSegmentValByKey(2,2);
        $this->detailsAttrCoded = $this->getSegmentValByKey(2,3);
        $this->detailsAttr = $this->getSegmentValByKey(2,4);
        $this->unit = $this->getSegmentValByKey(3,0);
        $this->value = $this->getSegmentValByKey(3,1);
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->qualifier.'+'.
            $this->details.':'.$this->detailsDimension.':'.$this->detailsSignificance.':'.$this->detailsAttrCoded.':'.$this->detailsAttr.'+'.
            $this->unit.':'.
            $this->value.'\'';
    }
}

?>
