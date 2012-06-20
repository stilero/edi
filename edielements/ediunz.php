<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ediunz
 *
 * @author Daniel Eliasson (joomla at stilero.com)
 */
require_once 'edielement.php';

class EdiUNZ extends EdiElement{
    var $name = 'Interchange Trailer';
    var $identifier = 'UNZ';
    protected $controlCount;
    protected $controlRef;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
        $this->controlCount = $this->getSegmentValByKey(1);
        $this->controlRef = $this->getSegmentValByKey(2);
    }
    
    public function setControlCount($count){
        $this->controlCount = $count;
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->controlCount.'+'.
            $this->controlRef.'\'';
    }
}

?>
