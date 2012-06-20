<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of edidangerous
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiEQN extends EdiElement{
    var $name = 'Number of Units';
    var $identifier = 'EQN';
    protected $unitsQuantity;
    protected $unitType;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->unitsQuantity = $this->getSegmentValByKey(1,0);
        $this->unitType = $this->getSegmentValByKey(1,1);
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->unitsQuantity.':'.$this->unitType.'\'';
    }
}
?>
