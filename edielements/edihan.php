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

class EdiHAN extends EdiElement{
    var $name = 'Handling Instructions';
    var $identifier = 'HAN';
    public $hanInstr;
    protected $hazMaterial;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->hanInstr = $this->getSegmentValByKey(1);
        $this->hazMaterial = $this->getSegmentValByKey(2);
    }
    
    public function stringElement(){
        return $this->identifier.'+'.$this->hanInstr.'\'';
    }
}
?>
