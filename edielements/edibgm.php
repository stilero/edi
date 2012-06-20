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

class EdiBGM extends EdiElement{
    var $name = 'Beginning of Message';
    var $identifier = 'BGM';
    protected $messageName;
    protected $messageNr;
    protected $messageFunction;
    
    public function __construct($identifier, $elementData) {
        parent::__construct($identifier, $elementData);
    }
    
    public function buildElement() {
        parent::buildElement();
        $this->messageName = $this->getSegmentValByKey(1);
        $this->messageNr = $this->getSegmentValByKey(2);
        $this->messageFunction = $this->getSegmentValByKey(3);
    }
    
    public function stringElement(){
        return 
            $this->identifier.'+'.
                $this->messageName.'+'.
                $this->messageNr.'+'.
                $this->messageFunction.
                '\'';
    }
}

?>
